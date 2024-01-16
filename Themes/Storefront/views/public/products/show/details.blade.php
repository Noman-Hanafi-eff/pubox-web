<div class="product-details-info position-relative flex-grow-1">
    <div class="details-info-top">
        <h1 class="product-name">{{ $product->name }}</h1>
        
        @if (setting('reviews_enabled'))
            <product-rating
                :rating-percent="ratingPercent"
                :review-count="totalReviews"
            >
            </product-rating>
        @endif

        <template v-cloak v-if="item.is_in_stock">
            <div
                v-if="item.does_manage_stock"
                class="availability in-stock"
            >
                @{{ $trans('storefront::product.left_in_stock', { count: item.qty }) }}
            </div>

            <div v-else class="availability in-stock">
                {{ trans('storefront::product.in_stock') }}
            </div>
        </template>

        <div
            v-cloak
            v-else-if="item.is_out_of_stock"
            class="availability out-of-stock"
        >
            {{ trans('storefront::product.out_of_stock') }}
        </div>

        <div class="brief-description">
            {!! $product->short_description !!}
        </div>

        <div class="details-info-top-actions">
            <button
                class="btn btn-wishlist"
                :class="{ 'added': inWishlist }"
                @click="syncWishlist"
            >
                <i class="la-heart" :class="inWishlist ? 'las' : 'lar'"></i>
                {{ trans('storefront::product.wishlist') }}
            </button>

            <button
                class="btn btn-compare"
                :class="{ 'added': inCompareList }"
                @click="syncCompareList"
            >
                <i class="las la-random"></i>
                {{ trans('storefront::product.compare') }}
            </button>
        </div>
    </div>

    <div class="details-info-middle">
        @if ($product->variant)
            <div v-if="isActiveItem" class="product-price" v-html="item.formatted_price">
                {!! $item->is_active ? $item->formatted_price : '' !!}
            </div>
        @else
            <div class="product-price" v-html="item.formatted_price">
                {!! $item->formatted_price !!}
            </div>
        @endif

        <form
            @input="errors.clear($event.target.name)"
            @submit.prevent="addToCart"
        >
            @if ($product->variant)
                <div class="product-variants">
                    @include('public.products.show.variations')
                </div>
            @endif

            <div class="product-variants">
                @foreach ($product->options as $option)
                    @includeIf("public.products.show.custom_options.{$option->type}")
                @endforeach
            </div>

            <div class="details-info-middle-actions">
                <div class="number-picker-lg">
                    <label for="qty">{{ trans('storefront::product.quantity') }}</label>

                    <div class="input-group-quantity">
                        <input
                            type="text"
                            :value="cartItemForm.qty"
                            min="1"
                            :max="maxQuantity"
                            id="qty"
                            class="form-control input-number input-quantity"
                            :disabled="isAddToCartDisabled"
                            @focus="$event.target.select()"
                            @input="updateQuantity(Number($event.target.value))"
                            @keydown.up="updateQuantity(cartItemForm.qty + 1)"
                            @keydown.down="updateQuantity(cartItemForm.qty - 1)"
                        >

                        <span class="btn-wrapper">
                            <button
                                type="button"
                                aria-label="quantity"
                                class="btn btn-number btn-plus"
                                :disabled="isQtyIncreaseDisabled"
                                @click="updateQuantity(cartItemForm.qty + 1)"
                            >
                                +
                            </button>

                            <button
                                type="button"
                                aria-label="quantity"
                                class="btn btn-number btn-minus"
                                :disabled="isQtyDecreaseDisabled"
                                @click="updateQuantity(cartItemForm.qty - 1)"
                            >
                                -
                            </button>
                        </span>
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-add-to-cart"
                    :class="{'btn-loading': addingToCart }"
                    :disabled="isAddToCartDisabled"
                    v-text="isActiveItem ? $trans('storefront::product.add_to_cart') : $trans('storefront::product.unavailable')"
                >
                    {{ trans($item->is_active ? 'storefront::product.add_to_cart' : 'storefront::product.unavailable') }}
                </button>
            </div>
        </form>
    </div>

    <div class="details-info-bottom">
        <ul class="list-inline additional-info">
            <li v-cloak v-if="item.sku" class="sku">
                <label>{{ trans('storefront::product.sku') }}</label>
                <span v-text="item.sku">{{ $item->sku }}</span>
            </li>

            @if ($product->categories->isNotEmpty())
                <li>
                    <label>{{ trans('storefront::product.categories') }}</label>

                    @foreach ($product->categories as $category)
                        <a href="{{ $category->url() }}">{{ $category->name }}</a>{{ $loop->last ? '' : ',' }}
                    @endforeach
                </li>
            @endif

            @if ($product->tags->isNotEmpty())
                <li>
                    <label>{{ trans('storefront::product.tags') }}</label>

                    @foreach ($product->tags as $tag)
                        <a href="{{ $tag->url() }}">{{ $tag->name }}</a>{{ $loop->last ? '' : ',' }}
                    @endforeach
                </li>
            @endif
        </ul>

        @include('public.products.show.social_share')
    </div>
</div>