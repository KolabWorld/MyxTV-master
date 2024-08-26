<?php namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
// use Webklex\PHPIMAP\ClientManager;
// use Webklex\PHPIMAP\Client;

class IMAPController extends Controller {

	public function __construct(){
		// $this->middleware('auth');
	}

	public function index() {
		// $cm = new ClientManager('config/imap.php');

		// // or use an array of options instead
		// $cm = new ClientManager($options = []);

		// /** @var \Webklex\PHPIMAP\Client $client */
		// // $client = $cm->account('gmail');

		// // or create a new instance manually
		// $client = $cm->make([
		//     'host'          => 'imap.gmail.com',
		//     'port'          => 993,
		//     'encryption'    => 'ssl',
		//     'validate_cert' => false,
		//     'username'      => 'akash.chaudhary.as@gmail.com',
		//     'password'      => 'Akash@123',
		//     'protocol'      => 'imap'
		// ]);

		// //Connect to the IMAP Server
		// $client->connect();
		
		$client = Client::account('gmail');

		$client->connect();
		// $folders = $client->getFolders();
		// foreach($folders as $folder){
		// 	$messages = $folder->messages()->all()->get();
		// 	foreach($messages as $message){
		// 		echo $message->getSubject().'<br />';
		// 		echo 'Attachments: '.$message->getAttachments()->count().'<br />';
		// 		echo $message->getHTMLBody();
				
		// 		//Move the current Message to 'INBOX.read'
		// 		if($message->move('INBOX.read') == true){
		// 			echo 'Message has ben moved';
		// 		}else{
		// 			echo 'Message could not be moved';
		// 		}
		// 	}
		// }
	}
}
