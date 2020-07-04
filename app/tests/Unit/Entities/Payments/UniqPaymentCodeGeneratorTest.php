<?php

namespace Tests\Unit\Entities\Payments;

use Tests\TestCase;
use App\Entities\Payments\UniqPaymentCodeGenerator;

class UniqPaymentCodeGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_must_be_16_charset_long()
    {
        $generator=new UniqPaymentCodeGenerator();
        $code=$generator->generate();
        $this->assertEquals(16,strlen($code));
    }

    /**
     * @test
     */
    public function it_can_only_contain_uppercase_letters_and_numbers()
    {
        $generator=new UniqPaymentCodeGenerator();
        $code=$generator->generate();
        $this->assertRegExp('/^[A-Z0-9]*$/',$code);
    }

    /**
     * @test
     */
    public function code_must_be_unique()
    {
        $codes=collect();
        for($i=0;$i<1000;$i++){
            $codes->push((new UniqPaymentCodeGenerator())->generate());
        }
        $this->assertEquals($codes->count(),$codes->unique()->count());

    }
}
