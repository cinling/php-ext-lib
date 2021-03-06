<?php


use cin\extLib\traits\TimeTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeTraitTest
 */
class TimeTraitTest extends TestCase {

    /**
     * @test
     */
    public function getMondayStamp() {
        $this->assertEquals(strtotime("2020-12-21"), TimeTrait::getMonday(strtotime("2020-12-27")));
        $this->assertEquals(strtotime("2020-12-28"), TimeTrait::getMonday(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getTuesdayStamp() {
        $this->assertEquals(strtotime("2020-12-29"), TimeTrait::getTuesday(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getWednesdayStamp() {
        $this->assertEquals(strtotime("2020-12-30"), TimeTrait::getWednesday(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getThursdayStamp() {
        $this->assertEquals(strtotime("2020-12-31"), TimeTrait::getThursday(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getFridayStamp() {
        $this->assertEquals(strtotime("2021-01-01"), TimeTrait::getFriday(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getSaturdayStamp() {
        $this->assertEquals(strtotime("2021-01-02"), TimeTrait::getSaturday(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getSundayStamp() {
        $this->assertEquals(strtotime("2021-01-03"), TimeTrait::getSunday(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getMonthStart() {
        $this->assertEquals(strtotime("2020-12-01"), TimeTrait::getMonthStart(strtotime("2020-12-29")));
    }

    /**
     * @test
     */
    public function getMonthEnd() {
        $this->assertEquals(strtotime("2020-12-31 23:59:59"), TimeTrait::getMonthEnd(strtotime("2020-12-10")));
    }

    /**
     * @test
     */
    public function prevMonth() {
        $this->assertEquals(strtotime("2021-02-28 10:00:00"), TimeTrait::prevMonth(strtotime("2021-03-31 10:00:00")));
        $this->assertEquals(strtotime("2020-02-29 10:00:00"), TimeTrait::prevMonth(strtotime("2020-03-31 10:00:00")));
        $this->assertEquals(strtotime("2020-05-30 19:23:51"), TimeTrait::prevMonth(strtotime("2020-06-30 19:23:51")));
        $this->assertEquals(strtotime("2020-04-30 19:23:51"), TimeTrait::prevMonth(strtotime("2020-06-30 19:23:51"), 2));
        $this->assertEquals(strtotime("2020-02-29 19:23:51"), TimeTrait::prevMonth(strtotime("2020-07-31 19:23:51"), 5));
    }

    /**
     * @test
     */
    public function nextMonth() {
        $exp = TimeTrait::toDatetime(strtotime("2021-02-28 10:00:00"));
        $act = TimeTrait::toDatetime(TimeTrait::nextMonth(strtotime("2021-01-31 10:00:00")));
        $this->assertEquals($exp, $act);
        $this->assertEquals(strtotime("2020-02-29 10:00:00"), TimeTrait::nextMonth(strtotime("2020-01-31 10:00:00")));
        $this->assertEquals(strtotime("2020-07-30 19:23:51"), TimeTrait::nextMonth(strtotime("2020-06-30 19:23:51")));
        $this->assertEquals(strtotime("2020-02-29 19:23:51"), TimeTrait::nextMonth(strtotime("2020-01-31 19:23:51")));
        $this->assertEquals(strtotime("2021-02-28 19:23:51"), TimeTrait::nextMonth(strtotime("2020-02-29 19:23:51"), 12));
        $this->assertEquals(strtotime("2020-08-30 19:23:51"), TimeTrait::nextMonth(strtotime("2020-06-30 19:23:51"), 2));
    }

    /**
     * @test
     */
    public function nextDay() {
        $exp = "2020-02-29 15:02:01";
        $act = TimeTrait::toDatetime(TimeTrait::nextDay("2020-02-28 15:02:01"));
        $this->assertEquals($exp, $act);

        $exp = "2020-03-01 15:02:01";
        $act = TimeTrait::toDatetime(TimeTrait::nextDay("2020-02-28 15:02:01", 2));
        $this->assertEquals($exp, $act);
    }

    /**
     * @test
     */
    public function getDateStart() {
        $this->assertEquals("2020-12-12 00:00:00", TimeTrait::toDatetime(TimeTrait::getDateStart("2020-12-12 12:11:22")));
    }

    /**
     * @test
     */
    public function getDateEnd() {
        $this->assertEquals("2020-12-12 23:59:59", TimeTrait::toDatetime(TimeTrait::getDateEnd("2020-12-12 12:11:22")));
    }

    /**
     * @test
     */
    public function prevYear() {
        $this->assertEquals(strtotime("2019-01-01"), TimeTrait::prevYear("2020-01-01"));
        $this->assertEquals(strtotime("2019-02-28"), TimeTrait::prevYear("2020-02-29"));
        $this->assertEquals(strtotime("2020-03-01"), TimeTrait::prevYear("2021-03-01"));
    }

    /**
     * @test
     */
    public function nextYear() {
        $this->assertEquals(strtotime("2020-03-01"), TimeTrait::nextYear("2019-03-01"));
        $this->assertEquals(strtotime("2021-02-28"), TimeTrait::nextYear("2020-02-29"));
    }

    /**
     * @test
     */
    public function getYearStart() {
        $this->assertEquals(strtotime("2020-01-01"), TimeTrait::getYearStart("2020-12-22 12:12:12"));
        $this->assertEquals(strtotime("2020-01-01"), TimeTrait::getYearStart("2020-01"));
    }

    /**
     * @test
     */
    public function getYearEnd() {
        $this->assertEquals(strtotime("2020-12-31 23:59:59"), TimeTrait::getYearEnd("2020-12-22 12:12:12"));
    }

    /**
     * @test
     */
    public function yesterday() {
        $this->assertEquals(strtotime(date("Y-m-d", time() - 86400)), TimeTrait::yesterday());
    }

    /**
     * @test
     */
    public function tomorrow() {
        $this->assertEquals(strtotime(date("Y-m-d", time() + 86400)), TimeTrait::tomorrow());
    }

    /**
     * @test
     */
    public function comSpaceDays() {
        $this->assertEquals(10, TimeTrait::comSpaceDays("2020-01-01", "2020-01-11"));
        $this->assertEquals(10, TimeTrait::comSpaceDays("2020-01-11", "2020-01-01"));
        $this->assertEquals(0, TimeTrait::comSpaceDays("2020-01-01", "2020-01-01"));
        $this->assertEquals(0, TimeTrait::comSpaceDays("2020-01-01", "2020-01-01"));
        $this->assertEquals(2, TimeTrait::comSpaceDays("2021-01-01", "2021-01-03"));
    }

    /**
     * @test
     */
    public function getWeeks() {
        $this->assertEquals(1, TimeTrait::getWeeks("2000-01-01"));
        $this->assertEquals(1, TimeTrait::getWeeks("2021-01-01"));
        $this->assertEquals(1, TimeTrait::getWeeks("2021-01-03"));
        $this->assertEquals(2, TimeTrait::getWeeks("2021-01-04"));
        $this->assertEquals(2, TimeTrait::getWeeks("2021-01-10"));
    }
}
