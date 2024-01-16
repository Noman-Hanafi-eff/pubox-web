<template v-else-if="section === 'inventory'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.inventory') }}</h5>

        <div class="drag-handle">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
    </div>

    <div class="box-body">
        <div v-if="hasAnyVariant" class="alert alert-info">
            {{ trans('product::products.variants.has_product_variant') }}
        </div>
        
        <template v-else>
            <div class="form-group">
                <label for="sku" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.sku') }}
                </label>
                
                <div class="col-sm-9">
                    <input
                        type="text"
                        name="sku"
                        id="sku"
                        class="form-control"
                        v-model="form.sku"
                    >

                    <span class="help-block text-red" v-if="errors.has('sku')" v-text="errors.get('sku')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="manage-stock" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.manage_stock') }}
                </label>

                <div class="col-sm-9">
                    <select
                        name="manage_stock"
                        id="manage-stock"
                        class="form-control custom-select-black"
                        @change="focusField({
                            selector: '#qty'
                        })"
                        v-model.number="form.manage_stock"
                    >
                        <option value="0">{{ trans('product::products.form.manage_stock_states.0') }}</option>
                        <option value="1">{{ trans('product::products.form.manage_stock_states.1') }}</option>
                    </select>
                    
                    <span class="help-block text-red" v-if="errors.has('manage_stock')" v-text="errors.get('manage_stock')"></span>
                </div>
            </div>

            <div class="form-group" v-if="form.manage_stock == 1">
                <label for="qty" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.qty') }}
                    <span class="text-red">*</span>
                </label>

                <div class="col-sm-9">
                    <input
                        type="number"
                        min="0"
                        name="qty"
                        step="1"
                        id="qty"
                        class="form-control"
                        @wheel="$event.target.blur()"
                        v-model.number="form.qty"
                    >
                    
                    <span class="help-block text-red" v-if="errors.has('qty')" v-text="errors.get('qty')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="in-stock" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.in_stock') }}
                </label>

                <div class="col-sm-9">
                    <select
                        name="in_stock"
                        id="in-stock"
                        class="form-control custom-select-black"
                        v-model.number="form.in_stock"
                    >
                        <option value="1">{{ trans('product::products.form.stock_availability_states.1') }}</option>
                        <option value="0">{{ trans('product::products.form.stock_availability_states.0') }}</option>
                    </select>
                    
                    <span class="help-block text-red" v-if="errors.has('in_stock')" v-text="errors.get('in_stock')"></span>
                </div>
            </div>
        </template>
    </div>
</template>