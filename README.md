# filament-nested-repeater-w-relationship

Following the example of using a repeater to fill BelongsToMany relationships [https://filamentphp.com/docs/3.x/forms/fields/repeater], I want to nest two repeaters with BelongsToMany relationships to handle a scenario like this:

I have Orders that have Products, which in turn have Colors.

I'm encountering a bug during the initial save: the color is not saved correctly because the `order_product_id` column in the `color_order_product` table is null. However, if I add new colors to a product in the order afterward, the modification is saved correctly.

But if I add a new product, the same issue arises.

```php
Repeater::make('order_product')
    ->relationship('orderProducts')
    ->schema([
        Select::make('product_id')
            ->relationship('product', 'title')
            ->required()
            ->live(),
        Repeater::make('colorOrderProducts')
            ->relationship('colorOrderProducts')
            ->schema([
                Select::make('color_id')
                    ->options(
                        function ($get) {
                            $selectedProduct = Product::find($get('../../product_id'));
                            if ($selectedProduct) {
                                return $selectedProduct->colors()->get()->pluck('title', 'id');
                            }
                        }
                    )
                    ->required(),
            ])
    ])
```

### Issue Description

When nesting repeaters for BelongsToMany relationships, the initial save operation fails to properly associate colors with the `order_product` because the `order_product_id` column in the `color_order_product` table is null. This only occurs during the initial save. Subsequent modifications, such as adding new colors to an existing product in an order, work as expected. However, adding a new product results in the same issue.

### Steps to Reproduce

1. Create an order with products and assign colors to those products using the nested repeater.
2. Save the order.
3. Check the `color_order_product` table and observe that the `order_product_id` column is null for the initially added colors.
4. Add new colors to the existing product and save again. Observe that these new colors are saved correctly.
5. Add a new product to the order and assign colors. Save and observe the issue reoccurs.

### Proposed Solution

To address this issue, the nested repeater needs to correctly set the `order_product_id` during the initial save. One possible solution is to ensure that the parent repeater (for products) saves first, so the nested repeater (for colors) can reference the correct `order_product_id`.

Any insights or suggestions to resolve this issue would be greatly appreciated.
