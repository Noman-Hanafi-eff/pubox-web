<?php

namespace Modules\Attribute\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;

class AttributeTable extends AdminTable
{
    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('attribute_set', function ($attribute) {
                return $attribute->attributeSet->name;
            })
            ->addColumn('is_filterable', function ($attribute) {
                return $attribute->is_filterable
                    ? trans('attribute::admin.table.yes')
                    : trans('attribute::admin.table.no');
            });
    }
}
