<?php
namespace Yaw\Event;
use Yaw\Core;
use \EventConfig as EventConfig;
use \EventBase   as EventBase;
use \Event       as Event;

class Libevent {

    const EV_READ  = 1;
    const EV_WRITE = 2;
    public $o_event_config = null;
    public $o_event_base   = null;

    /*
     * @desc : 保存事件event
     * */
    public $a_event  = array();

    //public $a_client = array();

    public function __construct() {
        $o_event_config = new EventConfig();
        $o_event_base   = new EventBase( $o_event_config );
        $this->o_event_config = $o_event_config;
        $this->o_event_base   = $o_event_base;
    }

    /*
     * @desc  : 添加一个事件
     * @param : socket fd
     * @param : event type, EV_READ EV_WRITE
     * @param : callback
     * */
    public function add( $r_fd, $i_event_type, $f_callback ) {
        $i_event_flag = $i_event_type == self::EV_READ ? Event::READ | Event::PERSIST : Event::WRITE | Event::PERSIST ;
        $o_event = new Event( $this->o_event_base, $r_fd, $i_event_flag, $f_callback );
        $o_event->add();
        $i_fd = intval( $r_fd );
        $this->a_event[ $i_fd ][ $i_event_type ] = $o_event;
    }

    /*
     * @desc : 删除一个事件
     * */
    public function del() {
    }

    /*
     * @desc : 陷入事件循环
     * */
    public function loop() {
        $this->o_event_base->loop();
    }

}