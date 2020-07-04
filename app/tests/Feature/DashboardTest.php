<?php

namespace Tests\Feature;

use App\Entities\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * @test
     */
    public function not_authenticated_user_can_not_see_dashboard()
    {
        $this->get('/payments/dashboard')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function it_retrievers_last_3_payments_of_each_type()
    {
        //$paymentOne=factory(Payment::class)->create([]);
        $this->markTestIncomplete(
            'Этот тест ещё не реализован.'
        );
    }
}
