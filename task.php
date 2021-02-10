<?php

class Task {
  
  const STATUS_NEW = 'НОВЫЙ';
  const STATUS_WORK = 'В РАБОТЕ';
  const STATUS_CANCELLED = 'ОТМЕНЕНО';
  const STATUS_DONE = 'ВЫПОЛНЕНО';
  const STATUS_FAILED = 'ПРОВАЛЕНО';
  const ACTION_CANCEL = 'ОТМЕНИТЬ';
  const ACTION_RESPOND = 'ОТКЛИКНУТЬСЯ';
  const ACTION_DONE = 'ВЫПОЛНЕНО';
  const ACTION_REFUSE = 'ОТКАЗАТЬСЯ';

  public $idDoer;
  public $idClient;
  public $currentStatus;
  
  public function __construct($idDoer, $idClient, $currentStatus) {
    $this->idDoer = $idDoer; 
    $this->idClient = $idClient;
    $this->currentStatus = $currentStatus; 
  }
  
  public function getStatusAll() {
    $statusAll = ['new' => STATUS_NEW,
                 'work' => STATUS_WORK,
                 'cancelled' => STATUS_CANCELLED, 'done' => STATUS_DONE,
                 'failed' => STATUS_FAILED
                 ];
    return $statusAll;    
  }
  
  public function getActionsAll() {
    $actionAll = ['cancel' => ACTION_CANCEL,
                  'respond' => ACTION_RESPOND,   'done' => ACTION_DONE,
                  'refuse' => ACTION_REFUSE
                  ];
    return $actionAll;
  }

  public function getPosibleStatus($currentStatus) {
    switch($currentStatus) {
      case self::STATUS_NEW: return ['work' => STATUS_WORK, 'canceled' => STATUS_CANCELLED];
      case self::STATUS_WORK: return ['done' => STATUS_DONE, 'failed' => STATUS_FAILED];      
    } 
    return null;    
  }
  
  public function getPosibleActionForClient($currentStatus) {   
    switch($currentStatus) {
      case self::STATUS_NEW: return ['cancel' => ACTION_CANCEL];
      case self::STATUS_WORK: return ['done' => ACTION_DONE];
    }
    return null;
  }
  
  public function getPosibleActionForDoer($currentStatus) {
    switch($currentStatus) {
      case self::STATUS_NEW: return ['respond' => ACTION_RESPOND];
      case self::STATUS_WORK: return ['refuse' => ACTION_REFUSE];
      return null; 
    }
  }
}
