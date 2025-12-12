<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Client\Web\Requests\SubscriberRequest;
use App\Models\Subscriber;


class SubscriberController extends Controller
{
    public function mailing(SubscriberRequest $request)
    {

        $mailing = Subscriber::create($request->only('name', 'email'));
        $successMessage = 'Ви успішно додані до розсилки';

        return redirect()->back()->with(['success' => 'Ви успішно додані до розсилки!']);
    }
}
