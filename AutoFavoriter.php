<?php

	// TwitterOAuthの読み込み
	require ('twitteroauth/autoload.php');
	use Abraham\TwitterOAuth\TwitterOAuth;

	// 設定読み込み
	require_once (dirname(__FILE__).'/config.php');

	echo "\n".'  ***** AutoFavoriter v1.0 *****'."\n\n";

	try {
	
		// Twitterに接続
		$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $OAUTH_TOKEN, $OAUTH_TOKEN_SECRET);

		$info = $connection->get('account/verify_credentials');

		if (isset($info->errors)){

			// 例外
			echo '  Error: Connection to Twitter failed.'."\n";
			echo '  Exception: '.$info->errors[0]->message."\n\n";
			exit(1);

		}

	} catch(Exception $e) {

		// 例外
		echo '  Error: Connection to Twitter failed.'."\n";
		echo '  Exception: '.$e."\n\n";
		exit(1);

	}

	echo '  Connected to Twitter.'."\n\n";

	// 検索設定
	if ($retweet_ignore){

		// RTをいいねしないようにする
		$tweets_params = array('q' => $keywords.' exclude:retweets' ,'count' => $count, 'result_type' => $result_type);

	} else {

		// RTを検索結果に含める
		$tweets_params = array('q' => $keywords ,'count' => $count, 'result_type' => $result_type);

	}

	// ツイートを検索
	$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

	//　ツイートごとに実行
	foreach ($tweets as $key => $value) {
		
		if ($favorite) $connection->post('favorites/create', array('id' => $value->id)); // いいねを実行
		if ($retweet)  $connection->post('statuses/retweet', array('id' => $value->id)); // RT を実行

		// 実行タイプを判定
		if ($favorite and $retweet){
			$type = 'Favorite and Retweet';
		} else if ($favorite){
			$type = 'Favorite';
		} else if ($retweet){
			$type = 'Retweet';
		} else {
			$type = 'View';
		}

		// 表示
		echo '  '.$type.' '.sprintf('%02d', ($key + 1)).': Date: '.date('Y-m-d H:i:s', strtotime($value->created_at)).' ID: '.$value->id.
			 ' Tweet: '.str_replace("\n", '', mb_substr($value->text, 0, 16)).'…'."\n";

		// 高速で実行すると凍結しかねないのでランダムで1.5～4秒くらい間をおく
		$sleep = rand(150, 400) * 10000;
		usleep($sleep);

	}

	echo "\n".'  Finished. Exit.'."\n\n";
