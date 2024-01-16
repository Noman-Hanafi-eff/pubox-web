<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Address\Entities\DefaultAddress;

class AccountDefaultAddressController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return Renderable
     */
    public function update()
    {
        DefaultAddress::updateOrCreate(
            ['customer_id' => auth()->id()],
            ['address_id' => request('address_id')]
        );

        return trans('account::messages.default_address_updated');
    }
}
