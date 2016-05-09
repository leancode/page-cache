<?php
/**
 * This file is part of the PageCache package.
 *
 * @author Muhammed Mamedov <mm@turkmenweb.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PageCache\Tests;

use PageCache\SessionHandler;
use PageCache\Strategy\MobileStrategy;
use PageCache\StrategyInterface;

class MobileStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testStrategy()
    {
        //MobileDetection stub, to simulate a mobile device
        $mobilestub = $this->getMockBuilder('Mobile_Detect')
                           ->setMethods( array('isMobile','isTablet') )
                           ->getMock();

        $mobilestub->method('isMobile')
                    ->willReturn(true);

        $mobilestub->method('isTablet')
                    ->willReturn(false);

        $strategy = new MobileStrategy($mobilestub);

        //expected string, with -mob in the end
        SessionHandler::disable();
        $uri = empty($_SERVER['REQUEST_URI'])? '':$_SERVER['REQUEST_URI'];
        $md5 = md5( $uri . $_SERVER['SCRIPT_NAME'] . $_SERVER['QUERY_STRING']) . '-mob';

        $this->assertTrue($mobilestub instanceof \Mobile_Detect);
        $this->assertTrue($strategy instanceof StrategyInterface);
        $this->assertEquals($md5, $strategy->strategy());
    }
}