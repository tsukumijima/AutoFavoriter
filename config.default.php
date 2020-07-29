<?php

// ***** 検索設定 *****

// 検索キーワード
$keywords = '#きらファン夏休み';

// 取得するツイートの種類
//   popular … 人気のツイート
//   recent  … 最新のツイート
//   mixed   … 全てのツイート
$result_type = 'recent';

// 取得するツイート数 (1～100の間)
$count = 30;

// リツィートを検索結果から除外する
$retweet_ignore = true;


// ***** 実行設定 *****

// 取得したツイートにいいねを行う
$favorite = true;

// 取得したツイートにリツイートを行う
$retweet = false;


// ***** Twitter API 設定 *****

// コンシューマーキー
$CONSUMER_KEY =  'YOUR_CONSUMER_KEY';

// コンシューマーシークレットキー
$CONSUMER_SECRET = 'YOUR_CONSUMER_SECRET';

// アクセストークン
$OAUTH_TOKEN = 'YOUR_ACCESS_TOKEN';

// アクセストークンシークレット
$OAUTH_TOKEN_SECRET = 'YOUR_ACCESS_TOKEN_SECRET';
