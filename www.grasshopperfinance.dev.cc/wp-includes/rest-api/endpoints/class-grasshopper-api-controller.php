<?php

require 'data-news-articles.php';

 
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

    register_rest_route( $namespace, '/get_time_the_market_record_board' , array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => array( $this, 'get_time_the_market_record_board' ),
    ));

    register_rest_route( $namespace, '/get_time_the_market_news_articles' , array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => array( $this, 'get_time_the_market_news_articles' ),
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

  public function get_time_the_market_record_board( $request )
  {
    global $wpdb;
    
    // Avg beat by number of trades
    $sql = "SELECT COUNT(*) AS num_plays,
      SUM(CASE WHEN did_beat_market=true THEN 1 ELSE 0 END) / COUNT(*) AS percent_beats,
      AVG(beat_market_by_dollars) AS avg_beat_market_by_dollars,
      AVG(beat_market_by_percent) AS avg_beat_market_by_percent,
      AVG(num_trades),
      AVG(CASE WHEN did_beat_market=true THEN beat_market_by_dollars ELSE NULL END) as avg_beat_market_by_dollars_for_winners,
      AVG(CASE WHEN did_beat_market=false THEN beat_market_by_dollars ELSE NULL END) as avg_beat_market_by_dollars_for_losers,
      AVG(CASE WHEN did_beat_market=true THEN beat_market_by_percent ELSE NULL END) as avg_beat_market_by_percent_for_winners,
      AVG(CASE WHEN did_beat_market=false THEN beat_market_by_percent ELSE NULL END) as avg_beat_market_by_percent_for_losers,
      AVG(CASE WHEN did_beat_market=true THEN num_trades ELSE NULL END) as avg_num_trades_for_winners,
      AVG(CASE WHEN did_beat_market=false THEN num_trades ELSE NULL END) as avg_num_trades_for_losers
      FROM time_the_market_plays
      WHERE num_trades > 0
    ";

    $results = $wpdb->get_row( $sql );

    return new WP_REST_Response( $results, 200 );
  }  


  public function console_log( $data )
  {
    echo $data;
    // echo '<script>';
    // echo 'console.log('. json_encode( $data ) .')';
    // echo '</script>';
  }

  public function get_time_the_market_news_articles( $request )
  {
    global $wpdb;
    global $news_articles;

    $startDate = strtotime($request["market_start_date"]);
    $endDate = strtotime($request["market_end_date"]);

    $interval = ($endDate - $startDate) / 10.0;

    $currentDate = $startDate;
    $count = 0;

    $results = array();
    $currentLetter = 'A';

    for($i = 0; $i < count($news_articles) && $count < 10; $i++)
    {
      if(strtotime($news_articles[$i][1]) > $currentDate)
      {
          $article = $news_articles[$i];

          //Add a letter to identify each article on the chart
          array_push($article, $currentLetter);

          array_push($results, $article);
          $currentDate += $interval;
          $count++;
          $currentLetter++;
      }
    }

    return new WP_REST_Response( $results, 200 );

  }

}