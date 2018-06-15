<?php
 
class Grasshopper_API_Controller extends WP_REST_Controller {
 
  /**
   * Register the routes for the objects of the controller.
   */
  public function register_routes() {
    $version = '1';
    $namespace = 'ghapi/v' . $version;

    register_rest_route( $namespace, '/time_the_market_start_game' , array(
      'methods'  => WP_REST_Server::CREATABLE,
      'callback' => array( $this, 'time_the_market_start_game' ),
    ));

    register_rest_route( $namespace, '/time_the_market_end_game' , array(
      'methods'  => WP_REST_Server::CREATABLE,
      'callback' => array( $this, 'time_the_market_end_game' ),
    ));
  }

  public function time_the_market_start_game( $request ) {

    global $wpdb;
    $table = 'time_the_market_plays';

    $insertData = array(
      "ip_address" => $_SERVER['REMOTE_ADDR'],
      "market_start_date" => date("Y-m-d H:i:s", strtotime($request["market_start_date"])),
      "start_money" => $request["start_money"],
      "game_start_time" => date("Y-m-d H:i:s")
      );

    $success = $wpdb->insert($table,$insertData);

    //Get ID of inserted row...
    $my_id = $wpdb->insert_id;
 
    return new WP_REST_Response( $my_id, 200 );
  }  


  public function time_the_market_end_game( $request ) {

    global $wpdb;
    $table = 'time_the_market_plays';

    $updateData = array(
      "game_end_time" => date("Y-m-d H:i:s"),
      "num_trades" => $request["num_trades"],
      "did_beat_market" => $request["did_beat_market"],
      "beat_market_by_dollars" => $request["beat_market_by_dollars"],
      "beat_market_by_percent" => $request["beat_market_by_percent"],
      "market_end_date" => date("Y-m-d H:i:s", strtotime($request["market_end_date"])),
      "my_end_money" => $request["my_end_money"],
      "market_end_money" => $request["market_end_money"]
      );

    $whereArray = array( "id" => $request["id"]);

    $success = $wpdb->update($table,$updateData, $whereArray);

 
    return new WP_REST_Response( $success, 200 );
  }  
}