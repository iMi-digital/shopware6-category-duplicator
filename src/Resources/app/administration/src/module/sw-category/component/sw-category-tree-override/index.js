import template from './sw-category-tree.html.twig';

const { Component } = Shopware;
const { Criteria } = Shopware.Data;

Component.override('sw-category-tree', {
    template,
    methods: {
        async duplicateElement(contextItem) {
            const initContainer = Shopware.Application.getContainer('init');
            const headers = this.categoryRepository.buildHeaders();
            const httpClient = initContainer.httpClient;
            const that = this;
            await httpClient.post('/_admin/imidi-category-duplicator/clone-category/' + contextItem.id, {}, { headers }).then((clone) => {
                const criteria = new Criteria();
                criteria.setIds([clone.id]);
                that.categoryRepository.search(criteria).then((categories) => {
                    this.addCategories(categories);
                });
            }).catch((e) => {
                console.error(e);
                this.createNotificationError({
                    message: this.$tc('global.notification.unspecifiedSaveErrorMessage'),
                });
            });
        },
    }
});
