<?php>


class task {
  
  const STATUS_NEW = 'НОВЫЙ';
  const STATUS_WORK = 'В РАБОТЕ';
  const STATUS_CANCELLED = 'ОТМЕНЕНО';
  const STATUS_DONE = 'ВЫПОЛНЕНО';
  const STATUS_FAILED = 'ПРОВАЛЕНО';
  const ACTION_CANCEL = 'ОТМЕНИТЬ';
  const ACTION_RESPOND= 'ОТКЛИКНУТЬСЯ';
  const ACTION_DONE = 'ВЫПОЛНЕНО';
  const ACTION_REFUSE = 'ОТКАЗАТЬСЯ';

  public $idDoer;
  public $idClient;
  public $currentStatus;
  
  public function construct {
    this -> $idDoer = $idDoer;
    this -> $currentStatus = STATUS_NEW;    
  }
  
  public function getStatusAll() {
    $statusAll = ['new' -> STATUS_NEW,
                  'work' -> STATUS_WORK,'cancelled' -> STATUS_CANCELLED,'done' -> STATUS_DONE,
                  'failed' -> STATUS_FAILED
                 ];
    return $statusAll;    
  }
  
  public function getActionsAll() {
    $actionAll = ['cancel' -> ACTION_CANCEL,
                  'respond' -> ACTION_RESPOND,   'done' -> ACTION_DONE,
                  'refuse' -> ACTION_REFUSE
                  ];
    return $actionAll;
  }
  
  public function getPosibleStatus() {
    switch(this -> $currentStatus) {
      case STATUS_NEW: { return(['work' -> STATUS_WORK, 'canceled' -> STATUS_CANCELLED]);}
      case STATUS_WORK:  return (['done' -> STATUS_DONE, 'failed' -> STATUS_FAILED];
      case STATUS_DONE:  return;
      case STATUS_FAILED return;
    }    
  }
  
  public function getPosibleActionForClient() {
    switch(this -> $currentStatus) {
      case STATUS_NEW:  return ['cancel' -> ACTION_CANCEL];
      case STATUS_WORK  return ['done' -> ACTION_DONE];
      case STATUS_DONE:  return;
      case STATUS_FAILED return;
    }
  }
  
  public function getPosibleActionForDoer() {
    switch(this -> $currentStatus) {
      case STATUS_NEW:  return['respond' -> ACTION_RESPOND];
      case STATUS_WORK ( return (['refuse' -> ACTION_REFUSE]);}
      case STATUS_DONE:  return;
      case STATUS_FAILED return;
    }
  }
}