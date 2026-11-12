import template from './sw-category-tree.html.twig';

const { Component } = Shopware;
const { Criteria } = Shopware.Data;

Component.override('sw-category-tree', {
    template,
    methods: {
        duplicateElement(contextItem) {
            const initContainer = Shopware.Application.getContainer('init');
            const headers = this.categoryRepository.buildHeaders();
            const httpClient = initContainer.httpClient;

            return httpClient.post(
                '/_admin/imidi-category-duplicator/clone-category/' + contextItem.id,
                {},
                { headers },
            ).then((response) => {
                const criteria = new Criteria();
                criteria.setIds([response.data]);

                return this.categoryRepository.search(criteria);
            }).then((categories) => {
                this.addCategories(categories);
            }).catch((error) => {
                console.error(error);
                this.createNotificationError({
                    message: this.$t('global.notification.unspecifiedSaveErrorMessage'),
                });
            });
        },
    },
});
