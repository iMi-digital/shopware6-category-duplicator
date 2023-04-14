<?php declare(strict_types=1);

namespace iMidiCategoryDuplicator\Core\Framework\Api\Controller;

use Shopware\Core\Content\Category\CategoryCollection;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Write\CloneBehavior;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route(defaults={"_routeScope"={"api"}})
 */
class CloneCategoryController extends AbstractController
{
    private EntityRepository $categoryRepository;
    private TranslatorInterface $translator;
    private SystemConfigService $systemConfigService;

    public function __construct(EntityRepository $categoryRepository, TranslatorInterface $translator, SystemConfigService $systemConfigService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->translator = $translator;
        $this->systemConfigService = $systemConfigService;
    }

    /**
     * @Route("/api/_admin/imidi-category-duplicator/clone-category/{categoryId}", name="api.admin.imidi-category-duplicator.clone-category", methods={"POST"})
     */
    public function cloneCategory(string $categoryId, Request $request, Context $context): JsonResponse
    {
        $newId = Uuid::randomHex();

        $originalCategory = $this->categoryRepository->search(new Criteria([$categoryId]), $context)->first();

        $cloneBehavior = $this->getCloneBehavior(null, $originalCategory->getName()  . ' - Copy', $originalCategory->getParentId());

        $this->categoryRepository->clone($categoryId, $context, $newId, $cloneBehavior);
        $this->cloneChildren($categoryId, $newId, $context);

        return new JsonResponse($newId);
    }

    private function cloneChildren(string $parentId, string $newParentId, Context $context): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('parentId', $parentId));
        /** @var CategoryCollection $collection */
        $collection = $this->categoryRepository->search($criteria, $context)->getEntities();

        if ($collection->count() === 0) {
            return;
        }

        $children = $collection->sortByPosition();

        $previousId = null;
        foreach ($children as $child) {
            $cloneBehavior = $this->getCloneBehavior($previousId, null, $newParentId);

            $newId = Uuid::randomHex();
            $this->categoryRepository->clone($child->getId(), $context, $newId, $cloneBehavior);
            $this->cloneChildren($child->getId(), $newId, $context);

            $previousId = $newId;
        }
    }

    private function getCloneBehavior(?string $afterCategoryId, ?string $categoryName, ?string $categoryParentId): CloneBehavior
    {
        $behavior = [];
        $behavior['afterCategoryId'] = $afterCategoryId; // FIXME: Kind of random insert position, needs reorder of the tree, see https://github.com/iMi-digital/shopware6-category-duplicator/issues/1
        $behavior['parentId'] = $categoryParentId;

        if($categoryName !== null) {
            $behavior['name'] = $categoryName;// FIXME: use admin translation $this->translator->trans('global.default.copy')? see https://github.com/iMi-digital/shopware6-category-duplicator/issues/4
        }

        if(!$this->systemConfigService->get('iMidiCategoryDuplicator.config.cloneProductCategories')) {
            $behavior['products'] = null;
        }
        if(!$this->systemConfigService->get('iMidiCategoryDuplicator.config.cloneCustomFields')) {
            $behavior['customFields'] = null;
        }

        $cloneBehavior = new CloneBehavior($behavior, false);

        return $cloneBehavior;
    }
}
