<template v-if="section === 'price'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.pricing') }}</h5>

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
                <label for="price" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.price') }}
                    <span class="text-red">*</span>
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            @{{ defaultCurrencySymbol }}
                        </span>

                        <input
                            type="number"
                            min="0"
                            name="price"
                            step="0.1"
                            id="price"
                            class="form-control"
                            @wheel="$event.target.blur()"
                            v-model="form.price"
                        >
                    </div>

                    <span class="help-block text-red" v-if="errors.has('price')" v-text="errors.get('price')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price') }}
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            @{{ form.special_price_type === 'fixed' ? defaultCurrencySymbol : '%' }}
                        </span>

                        <input
                            type="number"
                            min="0"
                            name="special_price"
                            step="0.1"
                            id="special-price"
                            class="form-control"
                            @wheel="$event.target.blur()"
                            v-model="form.special_price"
                        >
                    </div>

                    <span class="help-block text-red" v-if="errors.has('special_price')" v-text="errors.get('special_price')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price-type" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price_type') }}
                </label>

                <div class="col-sm-9">
                    <select
                        name="special_price_type"
                        id="special-price-type"
                        class="form-control custom-select-black"
                        v-model="form.special_price_type"
                        
                    >
                        <option value="fixed">
                            {{ trans('product::products.form.special_price_types.fixed') }}
                        </option>
                        
                        <option value="percent">
                            {{ trans('product::products.form.special_price_types.percent') }}
                        </option>
                    </select>
                    
                    <span class="help-block text-red" v-if="errors.has('special_price_type')" v-text="errors.get('special_price_type')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price-start" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price_start') }}
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>

                        <flat-pickr
                            name="special_price_start"
                            id="special-price-start"
                            class="form-control"
                            :config="flatPickrConfig"
                            v-model="form.special_price_start"
                        >
                        </flat-pickr>
                    </div>

                    <span class="help-block text-red" v-if="errors.has('special_price_start')" v-text="errors.get('special_price_start')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price-end" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price_end') }}
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>

                        <flat-pickr
                            name="special_price_end"
                            id="special-price-end"
                            class="form-control"
                            :config="flatPickrConfig"
                            v-model="form.special_price_end"
                        >
                        </flat-pickr>
                    </div>

                    <span class="help-block text-red" v-if="errors.has('special_price_end')" v-text="errors.get('special_price_end')"></span>
                </div>
            </div>
        </template>
    </div>
</template>