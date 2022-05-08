<?php
date_default_timezone_set('Asia/Baghdad');
if(!file_exists('config.json')){
	$token = readline('Enter Token: ');
	$id = readline('Enter Id: ');
	file_put_contents('config.json', json_encode(['id'=>$id,'token'=>$token]));
	
} else {
		  $config = json_decode(file_get_contents('config.json'),1);
	$token = $config['token'];
	$id = $config['id'];
}

if(!file_exists('accounts.json')){
    file_put_contents('accounts.json',json_encode([]));
}
include 'index.php';
try {
	$callback = function ($update, $bot) {
		global $id;
		if($update != null){
		  $config = json_decode(file_get_contents('config.json'),1);
		  $config['filter'] = $config['filter'] != null ? $config['filter'] : 1;
      $accounts = json_decode(file_get_contents('accounts.json'),1);
			if(isset($update->message)){
				$message = $update->message;
				$chatId = $message->chat->id;
				$text = $message->text;
				if($chatId == $id){
					if($text == '/start'){
              $bot->sendphoto([ 'chat_id'=>$chatId,
                  'photo'=>"https://t.me/LovetStore/487",
                   'caption'=>'  {ШΣLLΣCΘΜ ⁞✦⁽☻🔥₎“ٰۦ}👮تمت البرمجه بواسطه المطور👮 
@Snupx2 🌏  @SNUPER1 🌏  ',
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'👾تسجيل الدخول حساب أنستقرام👾','callback_data'=>'login']],
                       [['text'=>"🇹🇳🥵المطور الأساسي لي السورس 🌏🖤 برمجة بواسطة Hamza ✨", 'url'=>"https://t.me/SNUPER1"]],
                      ]
                  ])
              ]);   
             
             $bot->sendvideo([ 'chat_id'=>$chatId,
                  'video'=>"https://t.me/LovetStore/485",
                   'caption'=>'🥵🥵هدية من المطور 🌟👾',

                ]);

               
                 $bot->sendvoice([ 'chat_id'=>$chatId,
                  'voice'=>"https://t.me/Snupx2/270",
                   'caption'=>'😈🌟موسيقة حامسية🌟😈️',

                ]);

          } elseif($text != null){
          	if($config['mode'] != null){
          		$mode = $config['mode'];
          		if($mode == 'addL'){
          			$ig = new ig(['file'=>'','account'=>['useragent'=>'Instagram 27.0.0.7.97 Android (23/6.0.1; 640dpi; 1440x2392; LGE/lge; RS988; h1; h1; en_US)']]);
          			list($user,$pass) = explode(':',$text);
          			list($headers,$body) = $ig->login($user,$pass);
          			// echo $body;
          			$body = json_decode($body);
          			if(isset($body->message)){
          				if($body->message == 'challenge_required'){
          					$bot->sendMessage([
          							'chat_id'=>$chatId,
          							'parse_mode'=>'markdown',
          							'text'=>"💀لقد تم رفض الحساب لانه محظور او انه يطلب مصادقه يرجي تجربة حساب جديد وشكرا  😻💀️أو التواصل مع المطور @SNUPER1 💦"
          					]);
          				} else {
          					$bot->sendMessage([
          							'chat_id'=>$chatId,
          							'parse_mode'=>'markdown',
          							'text'=>"✋كلمه السر او اليوزر خطأ تأكد  من الكتبة بشكل الصحيح✋"
          					]);
          				}
          			} elseif(isset($body->logged_in_user)) {
          				$body = $body->logged_in_user;
          				preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
								  $CookieStr = "";
								  foreach($matches[1] as $item) {
								      $CookieStr .= $item."; ";
								  }
          				$account = ['cookies'=>$CookieStr,'useragent'=>'Instagram 27.0.0.7.97 Android (23/6.0.1; 640dpi; 1440x2392; LGE/lge; RS988; h1; h1; en_US)'];
          				
          				$accounts[$text] = $account;
          				file_put_contents('accounts.json', json_encode($accounts));
          				$mid = $config['mid'];
          				$bot->sendMessage([
          				      'parse_mode'=>'markdown',
          							'chat_id'=>$chatId,
          							'text'=>"ШΣLLΣCΘΜ ⁞✦⁽☻🔥₎“ٰۦ
👥تم اضافه حساب جديد الى الاداه 👥.*\n _Username_ : [$user])(instagram.com/$user)\n_Account Name_ : _{$body->full_name}_",
												'reply_to_message_id'=>$mid		
          					]);
          				$keyboard = ['inline_keyboard'=>[
										[['text'=> "👻أضافه حساب جديد👻",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"🏃تسجيل الخروج🏃",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'🎭الصفحه الرئيسية للبوت 🎭','callback_data'=>'back']];
		              $bot->editMessageText([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                  'text'=>"ШΣLLΣCΘΜ ⁞✦⁽☻🔥₎“ٰۦ
💗مرحبا هذه الصفحة توفر لك جميع الحسابات التي تم تسيجله في البوت 💥",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
		              $config['mode'] = null;
		              $config['mid'] = null;
		              file_put_contents('config.json', json_encode($config));
          			}
          		}  elseif($mode == 'selectFollowers'){
          		  if(is_numeric($text)){
          		    bot('sendMessage',[
          		        'chat_id'=>$chatId,
          		        'text'=>"👑تم التعديل👑.",
          		        'reply_to_message_id'=>$config['mid']
          		    ]);
          		    $config['filter'] = $text;
          		    $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                      'text'=>" ШΣLLΣCΘΜ ⁞✦⁽☻🔥₎“ٰۦ
الصفحه صفحة الوصول الخاصه بك عزيزي🎊 المستخدم  استمتع مع اسهل طريقه لسحب الحسابات واختراقه 🎊

لمراسلة الادمن - @SNUPER1",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'💀أضافه حساب جديد','callback_data'=>'login']],
                          [['text'=>'🙈طريقة سحب الحسابات من الانستقرام','callback_data'=>'grabber']],
                          [['text'=>'⏸تفعيل الفحص','callback_data'=>'run'],['text'=>'▶️ايقاف الفحص','callback_data'=>'stop']],
                              [['text'=>'🎯كشف حالة الحسابات المسجلة في الاداة🎯','callback_data'=>'status']],
                              [['text'=>' 👮مطور البوت👮','url'=>'t.me/Snupx2']],
                      ]
                  ])
                  ]);
          		    $config['mode'] = null;
		              $config['mid'] = null;
		              file_put_contents('config.json', json_encode($config));
          		  } else {
          		    bot('sendMessage',[
          		        'chat_id'=>$chatId,
          		        'text'=>'- ✒يرجى ارسال رقم فقط ✒.'
          		    ]);
          		  }
          		} else {
          		  switch($config['mode']){
          		    case 'search': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php search.php');
          		      break;
          		      case 'followers': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php followers.php');
          		      break;
          		      case 'following': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php following.php');
          		      break;
          		      case 'hashtag': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php hashtag.php');
          		      break;
          		  }
          		}
          	}
          }
				} else {
					$bot->sendphoto([
							'chat_id'=>$chatId,
							'photo'=> "https://t.me/LovetStore/493",
							 'caption'=>' ⠀ 
    ⠀  ⠀❆ＩＱ › ＢΔＧḤＤΔＤ ❉‏⠀
    ‌‏⠀(آ̀ن̀ت تس̀́تخد̀م̀ آ̀لن̀س̀́خة آ̀لم̀د̀ف̀وع̀́ة م̀ن̀ آ̀لآ̀د̀آ̀ة• 🌸💸 ❥˓ ֆ ☺️!)
                    ※•┈•ʚ♚ɞ•┈‏​•※
أيذا كنت توريد تحديث النسخة يرجي  مراسلة المطور👑👮',
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'▫️| Snupx2','url'=>'t.me/SNUPER1']],
                       [['text'=>"▪️| قناة البوت😳", 'url'=>"https://t.me/LovetStore"]],
                      ]
                  ])
              ]);   
				}
			} elseif(isset($update->callback_query)) {
          $chatId = $update->callback_query->message->chat->id;
          $mid = $update->callback_query->message->message_id;
          $data = $update->callback_query->data;
          echo $data;
          if($data == 'login'){
              
        		$keyboard = ['inline_keyboard'=>[
									[['text'=>"👥أضافه حساب  جديد👥",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"🏃تسجيل الخروج🏃",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>' ⁞✦⁽☻🔥₎“🎭️ الصفحه الرئيسية🎭','callback_data'=>'back']];
		              $bot->sendMessage([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                   'text'=>" ШΣLLΣCΘΜ ⁞✦⁽☻🔥₎“ٰۦ
☺مرحبا عزيزي المستخدم في الاسفل هي حساباتك المسجلة في الاداة☺",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
          } elseif($data == 'addL'){
          	
          	$config['mode'] = 'addL';
          	$config['mid'] = $mid;
          	file_put_contents('config.json', json_encode($config));
          	$bot->sendMessage([
          			'chat_id'=>$chatId,
          			'text'=>"  👻ارسل الحساب بهذا الشكل 👇👻 `email:password`",
          			'parse_mode'=>'markdown'
          	]);
          } elseif($data == 'grabber'){
            
            $for = $config['for'] != null ? $config['for'] : '😁حدد الحساب😁';
            $count = count(explode("\n", file_get_contents($for)));
            $bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>'🎭search🎭','callback_data'=>'search']],
                        [['text'=>'👻search sur hashtag👻 ','callback_data'=>'hashtag'],['text'=>'💀search surexplore💀','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"الحساب المحدد : $for",'callback_data'=>'for']],
                        [['text'=>'😚newList add 😚','callback_data'=>'newList'],['text'=>'🥳newList append 🥳','callback_data'=>'append']],
                        [['text'=>'🎭ШΣLLΣCΘΜ ⁞✦⁽☻🔥₎“ٰۦ️ الصفحه الرئيسية🎭 ','callback_data'=>'back']],
                        [['text'=>' 👮مطور البوت👮','url'=>'t.me/SNUPER1']],
                    ]
                ])
            ]);
          } elseif($data == 'search'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"📡الان قم بأرسال الكلمه التريد البحث عليها و ايضا يمكنك من استخدام اكثر من كلمه ولا تنسى وضع الفواصل المطور الرئيسي hamza👾🥵"
            ]);
            $config['mode'] = 'search';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'followers'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"🎉الان قم بأرسال اليوزر التريد سحب متابعيه و ايضا يمكنك من استخدام اكثر من يوزر عن طريق وضع فواصل بين اليوزرات 🎉"
            ]);
            $config['mode'] = 'followers';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'following'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"🎊الان قم بأرسال اليوزر التريد سحب الذي  متابعهم و ايضا يمكنك من استخدام اكثر من يوزر عن طريق وضع فواصل بين اليوزرات 🎊"
            ]);
            $config['mode'] = 'following';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'hashtag'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"الان قم بأرسال الهاشتاك بدون علامه # 
لا تنسى وضع هاشتاك واحد وشكرا😉"
            ]);
            $config['mode'] = 'hashtag';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'newList'){
            file_put_contents('a','new');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"تم اختيار 🚸 لستةة يوزرات جديده بنجاح",
							'show_alert'=>1
						]);
          } elseif($data == 'append'){ 
            file_put_contents('a', 'ap');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"تم اختيار 🚸 لستةة يوزرات سابقةة بنجاح",
							'show_alert'=>1
						]);
						
          } elseif($data == 'for'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'forg&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"اختار الحساب",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"اضف حساب بالاول😑",
							'show_alert'=>1
						]);
            }
          } elseif($data == 'selectFollowers'){
            bot('sendMessage',[
                'chat_id'=>$chatId,
                'text'=>'قم بأرسال عدد متابعين .'  
            ]);
            $config['mode'] = 'selectFollowers';
          	$config['mid'] = $mid;
          	file_put_contents('config.json', json_encode($config));
          } elseif($data == 'run'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'start&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"حدد حساب",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"قم بتسجيل حساب اولا 😑",
							'show_alert'=>1
						]);
            }
          }elseif($data == 'stop'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'stop&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"اختار الحساب",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"قم بتسجيل حساب اولا 😑",
							'show_alert'=>1
						]);
            }
          }elseif($data == 'stopgr'){
            shell_exec('screen -S gr -X quit');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"تم الانتهاء من السحب",
						// 	'show_alert'=>1
						]);
						$for = $config['for'] != null ? $config['for'] : 'Select Account';
            $count = count(explode("\n", file_get_contents($for)));
						$bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                       [['text'=>'🗣 بحث كلمات','callback_data'=>'search']],
                        [['text'=>'❗️بحث هاشتاك ','callback_data'=>'hashtag'],['text'=>'📈 من الاكسبلور','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"الحساب المحدد : $for",'callback_data'=>'for']],
                        [['text'=>'🚸 لستةة يوزرات جديده','callback_data'=>'newList'],['text'=>'🚸 لستةة يوزرات سابقةة','callback_data'=>'append']],
                        [['text'=>'♻️ الصفحه الرئيسية','callback_data'=>'back']],
                        [['text'=>' مطور البوت','url'=>'t.me/MAHAC9']],
                    ]
                ])
            ]);
          } elseif($data == 'explore'){
            exec('screen -dmS gr php explore.php');
          } elseif($data == 'status'){
					$status = '';
					foreach($accounts as $account => $ac){
						$c = explode(':', $account)[0];
						$x = exec('screen -S '.$c.' -Q select . ; echo $?');
						if($x == '0'){
				        $status .= "*$account* ~> _Working_\n";
				    } else {
				        $status .= "*$account* ~> _Stop_\n";
				    }
					}
					$bot->sendMessage([
							'chat_id'=>$chatId,
							'text'=>"حاله الحسابات : \n\n $status",
							'parse_mode'=>'markdown'
						]);
				} elseif($data == 'back'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=> "اهلا عزيزي ✔️
في الاسفل هي حساباتك الوهميه المسجله في الاداة",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'➕ أضافه حساب وهمي جديد','callback_data'=>'login']],
                          [['text'=>'💡 طرق سحب اليوزرات 💡','callback_data'=>'grabber']],
                          [['text'=>'⏸ بدء الصيد','callback_data'=>'run'],['text'=>'▶️ ايقاف الصيد','callback_data'=>'stop']],
                         [['text'=>'🌏 حالةة الحسابات الوهميةة 🌍','callback_data'=>'status']],
                         [['text'=>' مطور البوت','url'=>'t.me/MAHAC9']],
                      ]
                  ])
                  ]);
          } else {
          	$data = explode('&',$data);
          	if($data[0] == 'del'){
          		
          		unset($accounts[$data[1]]);
          		file_put_contents('accounts.json', json_encode($accounts));
              $keyboard = ['inline_keyboard'=>[
							[['text'=>"➕ أضافه حساب وهمي جديد",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"تسجيل الخروج",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'♻️ الصفحه الرئيسية','callback_data'=>'back']];
		              $bot->editMessageText([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                    'text'=>"اهلا عزيزي ✔️ في الاسفل هي حساباتك الوهميه المسجله في الاداة",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
          	} elseif($data[0] == 'forg'){
          	  $config['for'] = $data[1];
          	  file_put_contents('config.json',json_encode($config));
              $for = $config['for'] != null ? $config['for'] : 'Select';
              $count = count(file_get_contents($for));
              $bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                            [['text'=>'🗣 بحث كلمات','callback_data'=>'search']],
                        [['text'=>'❗️بحث هاشتاك ','callback_data'=>'hashtag'],['text'=>'📈 من الاكسبلور','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"For Account : $for",'callback_data'=>'for']],
                        [['text'=>'🚸 لستةة يوزرات جديده','callback_data'=>'newList'],['text'=>'🚸 لستةة يوزرات سابقةة','callback_data'=>'append']],
                        [['text'=>'♻️ الصفحه الرئيسية','callback_data'=>'back']],
                        [['text'=>' مطور البوت','url'=>'t.me/MAHAC9']],
                    ]
                ])
            ]);
          	} elseif($data[0] == 'start'){
          	  file_put_contents('screen', $data[1]);
          	  $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                       'text'=> "اهلا بك مره اخرى عزيزي ✔️
اختر ما تريده من الاسفل 👇",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'➕ أضافه حساب وهمي جديد','callback_data'=>'login']],
                          [['text'=>'💡 طرق سحب اليوزرات 💡','callback_data'=>'grabber']],
                          [['text'=>'⏸ بدء الصيد','callback_data'=>'run'],['text'=>'▶️ ايقاف الصيد','callback_data'=>'stop']],
                         [['text'=>'🌏 حالةة الحسابات الوهميةة 🌍','callback_data'=>'status']],
                         [['text'=>' مطور البوت','url'=>'t.me/MAHAC9']],
                      ]
                  ])
                  ]);
              exec('screen -dmS '.explode(':',$data[1])[0].' php start.php');
              $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"*بدء الصيد.*\n Account: `".explode(':',$data[1])[0].'`',
                'parse_mode'=>'markdown'
              ]);
          	} elseif($data[0] == 'stop'){
          	  $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                      'text'=>"اهلا بك مره اخرى عزيزي ✔️
اختر ما تريده من الاسفل 👇",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'➕ أضافه حساب وهمي جديد','callback_data'=>'login']],
                          [['text'=>'💡 طرق سحب اليوزرات 💡','callback_data'=>'grabber']],
                          [['text'=>'⏸ بدء الصيد','callback_data'=>'run'],['text'=>'▶️ ايقاف الصيد','callback_data'=>'stop']],
                         [['text'=>'🌏 حالةة الحسابات الوهميةة 🌍','callback_data'=>'status']],
                         [['text'=>' مطور البوت','url'=>'t.me/MAHAC9']],
                      ]
                    ])
                  ]);
              exec('screen -S '.explode(':',$data[1])[0].' -X quit');
          	}
          }
			}
		}
	};
	$bot = new EzTG(array('throw_telegram_errors'=>false,'token' => $token, 'callback' => $callback));
} catch(Exception $e){
	echo $e->getMessage().PHP_EOL;
	sleep(1);
}
