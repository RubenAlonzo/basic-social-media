<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';
require_once __DIR__ . '/FriendModelService.php';
require_once __DIR__ . '../../../Utilities/Utils.php';
require_once __DIR__ . '../../../database/Config.php';

class EventModelService extends ModelServiceBase{

  public function Create($idUser, $title, $place, $date){
    $query = $this->db->prepare(
      "INSERT INTO  event (id_user, title, place, date) values (?, ?, ?, ?)") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("isss", $idUser, $title, $place, $date);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();
    return $result;
  }

  public function GetEventInvitations($idUser){
    $result = $this->TryGetListById('*', 'invitation', 'id_invited', $idUser);
    $invitations = $result ? $result : array();

    $eventList = array();

    foreach($invitations as $invitation){
      $event = $this->GetEventById($invitation->id_event);
      if($event != null && !array_search($event, $eventList)){
        array_push($eventList, $event);
      }
    }
    return $eventList;
  }

  public function GetInvitation($idEvent, $idUser){
    $query = $this->db->prepare(
      "SELECT * FROM  invitation WHERE (id_event = ? AND id_invited = ?) LIMIT 1") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("ii", $idEvent, $idUser);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return new stdClass();
    return $result->fetch_object();
  }

  public function GetInvitationStatus($idEvent, $idUser){
    $invitation = $this->GetInvitation($idEvent, $idUser);
    return $invitation->status;
  }

  public function GetInvitationsToEvent($idEvent){
    $invitations = $this->TryGetListById('*', 'invitation', 'id_event', $idEvent);

    $invitationslist = array();

    foreach($invitations as $invitation){
      if(!array_search($invitation, $invitationslist)){
        array_push($invitationslist, $invitation);
      }
    }
    return $invitationslist;
  }

  public function GetMyEvents($idUser){
    $eventList = $this->TryGetListById('*', 'event', 'id_user', $idUser);
    return $eventList ? $eventList : array();
  }

  public function GetEventFromInvitation($idInvitation){
    $result = $this->TryGetRowById('*', 'invitation', 'id_invitation', $idInvitation);
    $invitation = $result ? $result : new stdClass();
    return $this->GetEventById($invitation->id_event);
  }

  public function GetEventById($idEvent){
    $event = $this->TryGetRowById('*', 'event', 'id_event', $idEvent);
    return $event ? (object)$event : null;
  }

  public function DeleteEvent($idEvent){
    return $this->DeleteById('event', 'id_event', $idEvent);
  }

  public function DeleteEventInvitation($id){
    return $this->DeleteById('invitation', 'id_invitation', $id);
  }

  public function SendEventInvitation($idEvent, $idReceiver){
    $query = $this->db->prepare(
      "INSERT INTO  invitation (id_event, id_invited) values (?, ?)") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("ii", $idEvent, $idReceiver);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();
    return $result;
  }

  public function ResponseEventInvitation($idInvitation, $response){
    return $this->UpdateFieldById('invitation', 'status', $response, 'id_invitation', $idInvitation);
  }

}