<?php
/**
 * Monad
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Monad\Test;

use Monad\Option\Some;
use Monad\Option\None;

class SomeTest extends \PHPUnit_Framework_TestCase
{
    public function testYouCanConstructASomeIfYouHaveAValueForIt()
    {
        $this->assertInstanceOf('Monad\Option\Some', new Some('foo'));
    }

    public function testYouCannotConstructASomeWithNoValue()
    {
        try {
            new Some();
        } catch (\Exception $e) {
            //php < 7.1
            $this->assertInstanceOf("PHPUnit_Framework_Error_Warning", $e);
        } catch (\ArgumentCountError $e) {
            //php >= 7.1
            $this->assertInstanceOf("ArgumentCountError", $e);
        }
    }

    public function testYouCanGetAValueFromASome()
    {
        $this->assertEquals('foo', (new Some('foo'))->value());
    }

    public function testBindingOnASomeMayReturnASomeOrANone()
    {
        $this->assertInstanceOf('Monad\Option\Some', (new Some('foo'))->bind(function($value){return $value;}));
        $this->assertInstanceOf('Monad\Option\None', (new Some('foo'))->bind(function($value){return null;}));
    }

    public function testBindingOnASomeTakesAThirdNonetestValue()
    {
        $sut = new Some('foo');
        $this->assertInstanceOf('Monad\Option\Some', $sut->bind(function($value){return true;}, [], false));
        $this->assertInstanceOf('Monad\Option\None', $sut->bind(function($value){return false;}, [], false));
    }
}
