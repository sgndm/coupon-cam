<?php

  class PushNotification {

    public function create_notification($notification, $data, $devices) {
      $content = array(
  		  'en' => $notification
  		);

  		$fields = array(
  		  'app_id' => "f4684a92-1815-445a-922f-166712ee8578",
  		  'include_player_ids' => $devices,
  		  'data' => $data,
  		  'contents' => $content
  		);

  		$fields = json_encode($fields);

  		$ch = curl_init();
  		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
  		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
  						   'Authorization: Basic YzdkMTg1ZjEtZjg5MS00NTY0LWIxMGMtNjJjN2M4N2QxMjA2'));
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  		curl_setopt($ch, CURLOPT_HEADER, FALSE);
  		curl_setopt($ch, CURLOPT_POST, TRUE);
  		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
  		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

  		$response = curl_exec($ch);
  		curl_close($ch);

  		return $response;
    }

}








?>
