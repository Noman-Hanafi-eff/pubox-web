<template v-else-if="section === 'variants'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.variants') }}</h5>

        <div class="d-flex">
            <span
                v-if="hasAnyVariant"
                class="toggle-accordion"
                :class="{ 'collapsed': isCollapsedVariantsAccordion }"
                data-toggle="tooltip"
                data-placement="top"
                :data-original-title="
                    isCollapsedVariantsAccordion ?
                    '{{ trans('product::products.section.expand_all') }}' :
                    '{{ trans('product::products.section.collapse_all') }}'
                "
                @click="toggleAccordions({
                    selector: '.variants-group .panel-heading',
                    state: isCollapsedVariantsAccordion,
                    data: form.variants
                })"
            >
                <i class="fa fa-angle-double-up" aria-hidden="true"></i>
            </span>

            <div class="drag-handle">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            </div>
        </div>
    </div>

    <div class="box-body">
        <div class="accordion-box-content">
            <div v-if="!hasAnyVariant" class="alert alert-info">
                {{ trans('product::products.variations.please_add_some_variations') }}
            </div>

            <template v-else>
                <div class="form-group">
                    <label for="default-variant" class="col-sm-3 control-label text-left">
                        {{ trans('product::products.form.variants.default_variant') }}
                    </label>

                    <div class="col-sm-5">
                        <select
                            name="default_variant"
                            id="default-variant"
                            class="form-control custom-select-black"
                            @change="changeDefaultVariant($event.target.value)"
                        >
                            <option
                                v-for="(variant, index) in form.variants"
                                :value="variant.uid"
                                :selected="defaultVariantUid === variant.uid"
                                :disabled="!isActiveVariant(index)"
                            >
                                @{{ variant.name }}
                            </option>
                        </select>
                    </div>
                </div>

                @include('product::admin.products.partials.bulk_edit_variants')
                
                <transition-group tag="div" name="variant" class="variants-group">
                    <div
                        v-for="(variant, index) in form.variants"
                        :id="`variant-${variant.uid}`"
                        class="content-accordion panel-group options-group-wrapper"
                        :key="variant.position"
                    >
                        <div class="panel panel-default">
                            <div class="panel-heading" @click.stop="toggleAccordion($event, variant)">
                                <h4 class="panel-title">
                                    <div
                                        :aria-expanded="variant.is_open"
                                        data-toggle="collapse"
                                        :href="`#variant-collapse-${variant.uid}`"
                                        :class="{
                                            'collapsed': !variant.is_open,
                                            'has-error': hasAnyError({
                                                name: 'variants',
                                                uid: variant.uid
                                            })
                                        }"
                                    >
                                        <div class="d-flex align-items-center">
                                            <div v-if="variant.is_selected" class="checkbox">
                                                <input
                                                    type="checkbox"
                                                    :name="`variants.${variant.uid}.is_selected`"
                                                    :id="`variants-${variant.uid}-is-selected`"
                                                    :checked="variant.is_selected"
                                                    disabled
                                                >

                                                <label :for="`variants-${variant.uid}-is-selected`"></label>
                                            </div>
                                            
                                            <span class="variant-name">@{{ variant.name }}</span>

                                            <ul class="variant-badge list-inline d-flex">
                                                <li v-if="variant.is_default">
                                                    <span class="label label-primary">
                                                        {{ trans('product::products.variants.default') }}
                                                    </span>
                                                </li>
                                                <li v-else-if="!variant.is_active">
                                                    <span class="label label-default">
                                                        {{ trans('product::products.variants.inactive') }}
                                                    </span>
                                                </li>
                                                <li v-if="variant.is_active && variant.in_stock == 0">
                                                    <span class="label label-warning">
                                                        {{ trans('product::products.variants.out_of_stock') }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="switch" @click.stop>
                                            <input
                                                type="checkbox"
                                                :name="`variants.${variant.uid}.is_active`"
                                                :id="`variants-${variant.uid}-is-active`"
                                                :disabled="defaultVariantUid === variant.uid"
                                                v-model="variant.is_active"
                                            >

                                            <label :for="`variants-${variant.uid}-is-active`" @click="changeVariantStatus(variant.uid)"></label>
                                        </div>
                                    </div>
                                </h4>
                            </div>

                            <div class="panel-collapse" :class="{ 'collapse': !variant.is_open }">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <draggable
                                                animation="200"
                                                class="product-media-grid"
                                                force-fallback="true"
                                                handle=".handle"
                                                :move="preventLastSlideDrag"
                                                :list="variant.media"
                                            >
                                                <div class="media-grid-item handle" v-for="(media, mediaIndex) in variant.media" :key="mediaIndex">
                                                    <div class="image-holder">
                                                        <img :src="media.path" alt="product variant media">

                                                        <button type="button" class="btn remove-image" @click="removeVariantMedia(index, mediaIndex)"></button>
                                                    </div>
                                                </div>

                                                <div class="media-grid-item media-picker disabled" @click="addVariantMedia(index)">
                                                    <div class="image-holder">
                                                        <img src="{{ asset('build/assets/placeholder_image.png') }}" class="placeholder-image" alt="Placeholder image">
                                                    </div>
                                                </div>
                                            </draggable>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="variant-fields">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-sku`">
                                                                {{ trans('product::products.form.variants.sku') }}
                                                            </label>

                                                            <input
                                                                type="text"
                                                                :name="`variants.${variant.uid}.sku`"
                                                                :id="`variants-${variant.uid}-sku`"
                                                                class="form-control"
                                                                v-model="variant.sku"
                                                            >

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.sku`)"
                                                                v-text="errors.get(`variants.${variant.uid}.sku`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-price`">
                                                                {{ trans('product::products.form.variants.price') }}
                                                                <span class="text-red">*</span>
                                                            </label>

                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    @{{ defaultCurrencySymbol }}
                                                                </span>

                                                                <input
                                                                    type="number"
                                                                    :name="`variants.${variant.uid}.price`"
                                                                    min="0"
                                                                    step="0.1"
                                                                    :id="`variants-${variant.uid}-price`"
                                                                    class="form-control"
                                                                    @wheel="$event.target.blur()"
                                                                    v-model.number="variant.price"
                                                                >
                                                            </div>

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.price`)"
                                                                v-text="errors.get(`variants.${variant.uid}.price`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-special-price`">
                                                                {{ trans('product::products.form.variants.special_price') }}
                                                            </label>

                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    @{{ variant.special_price_type === 'fixed' ? defaultCurrencySymbol : '%' }}
                                                                </span>
                                                                
                                                                <input
                                                                    type="number"
                                                                    :name="`variants.${variant.uid}.special_price`"
                                                                    min="0"
                                                                    step="0.1"
                                                                    :id="`variants-${variant.uid}-special-price`"
                                                                    class="form-control"
                                                                    @wheel="$event.target.blur()"
                                                                    v-model="variant.special_price"
                                                                >
                                                            </div>

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.special_price`)"
                                                                v-text="errors.get(`variants.${variant.uid}.special_price`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-special-price-type`">
                                                                {{ trans('product::products.form.variants.special_price_type') }}
                                                            </label>

                                                            <select
                                                                :name="`variants.${variant.uid}.special_price_type`"
                                                                :id="`variants-${variant.uid}-special-price-type`"
                                                                class="form-control custom-select-black"
                                                                v-model="variant.special_price_type"
                                                            >
                                                                <option value="fixed">
                                                                    {{ trans('product::products.form.variants.special_price_types.fixed') }}
                                                                </option>

                                                                <option value="percent">
                                                                    {{ trans('product::products.form.variants.special_price_types.percent') }}
                                                                </option>
                                                            </select>

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.special_price_type`)"
                                                                v-text="errors.get(`variants.${variant.uid}.special_price_type`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-special-price-start`">
                                                                {{ trans('product::products.form.variants.special_price_start') }}
                                                            </label>

                                                            <flat-pickr
                                                                :name="`variants.${variant.uid}.special_price_start`"
                                                                :id="`variants-${variant.uid}-special-price-start`"
                                                                class="form-control"
                                                                :config="flatPickrConfig"
                                                                v-model="variant.special_price_start"
                                                            >
                                                            </flat-pickr>

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.special_price_start`)"
                                                                v-text="errors.get(`variants.${variant.uid}.special_price_start`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-special-price-end`">
                                                                {{ trans('product::products.form.variants.special_price_end') }}
                                                            </label>

                                                            <flat-pickr
                                                                :name="`variants.${variant.uid}.special_price_end`"
                                                                :id="`variants-${variant.uid}-special-price-end`"
                                                                class="form-control"
                                                                :config="flatPickrConfig"
                                                                v-model="variant.special_price_end"
                                                            >
                                                            </flat-pickr>

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.special_price_end`)"
                                                                v-text="errors.get(`variants.${variant.uid}.special_price_end`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-manage-stock`">
                                                                {{ trans('product::products.form.variants.manage_stock') }}
                                                            </label>

                                                            <select
                                                                :name="`variants.${variant.uid}.manage_stock`"
                                                                :id="`variants-${variant.uid}-manage-stock`"
                                                                class="form-control custom-select-black"
                                                                @change="focusField({
                                                                    selector: `#variants-${variant.uid}-qty`,
                                                                    key: `variants.${variant.uid}.qty`
                                                                })"
                                                                v-model.number="variant.manage_stock"
                                                            >
                                                                <option value="0">
                                                                    {{ trans('product::products.form.variants.manage_stock_states.0') }}
                                                                </option>

                                                                <option value="1">
                                                                    {{ trans('product::products.form.variants.manage_stock_states.1') }}
                                                                </option>
                                                            </select>

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.manage_stock`)"
                                                                v-text="errors.get(`variants.${variant.uid}.manage_stock`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div v-if="variant.manage_stock == 1" class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-qty`">
                                                                {{ trans('product::products.form.variants.qty') }}<span class="text-red">*</span>
                                                            </label>

                                                            <input
                                                                type="number"
                                                                :name="`variants.${variant.uid}.qty`"
                                                                min="0"
                                                                step="1"
                                                                :id="`variants-${variant.uid}-qty`"
                                                                class="form-control"
                                                                @wheel="$event.target.blur()"
                                                                v-model="variant.qty"
                                                            >

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.qty`)"
                                                                v-text="errors.get(`variants.${variant.uid}.qty`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label :for="`variants-${variant.uid}-in-stock`">
                                                                {{ trans('product::products.form.variants.in_stock') }}
                                                            </label>

                                                            <select
                                                                :name="`variants.${variant.uid}.in_stock`"
                                                                :id="`variants-${variant.uid}-in-stock`"
                                                                class="form-control custom-select-black"
                                                                v-model="variant.in_stock"
                                                            >
                                                                <option value="0">
                                                                    {{ trans('product::products.form.variants.stock_availability_states.0') }}
                                                                </option>

                                                                <option value="1">
                                                                    {{ trans('product::products.form.variants.stock_availability_states.1') }}
                                                                </option>
                                                            </select>

                                                            <span
                                                                class="help-block text-red"
                                                                v-if="errors.has(`variants.${variant.uid}.in_stock`)"
                                                                v-text="errors.get(`variants.${variant.uid}.in_stock`)"
                                                            >
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </template>
        </div>
    </div>
</template>