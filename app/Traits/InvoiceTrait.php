<?php

namespace App\Traits;

use App\Models\Invoice;
use Illuminate\Http\Request;


trait InvoiceTrait
{
    public function saveInvoice($products, $taxes)
    {
        $total = $products->sum->price;
        $totalTax = $taxes->sum->rate * ($total / 100);
        $discount = 0;

        if ($products->count() >= 5) {
            $discount = ($total * 10) / 100;
            $sub_total = $total - $discount + $totalTax;
        } else {
            $sub_total = $total + $totalTax;
        }

        $invoice = Invoice::create(
            [
                'invoice_number' => uniqid(),
                'total_amount' => $total,
                'user_id' => auth()->user()->id,
                'sub_total' => $sub_total,
                'discount' =>  $discount,
                'invoiceDate' => getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'],
            ]
        );
        $invoice->products()->attach($products);
        $invoice->taxes()->attach($taxes);

        return $invoice;
    }
}
