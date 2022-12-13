<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\Request;

class WheelController extends Controller {
	public function wheel_users() {
		$users = User::whereNotIn('id', function ($q) {
			$q->select('winner_id')
				->from('winners')
				->whereColumn('winner_id', 'users.id');
		});
		$users = $users->inRandomOrder()->get();
		$winner_count = Winner::count();
		$probability = round(100 / count($users), 4);
		$users->map(function ($item) use ($probability) {
			$hexaCode = $this->getHexaCode();
			$item['bgColor'] = "#{$hexaCode}";
			$item['color'] = '#ffffff';
			$item['value'] = $item['id'];
			$item['probability'] = $item->probability;
			$item['weight'] = $item->weight;
			return $item;
		});
		return response()->json(compact('users'));
	}
	public function announce_winner(Request $request) {
		Winner::create([
			'winner_id' => $request->winner,
			'month' => date('F'),
			'year' => date('Y'),
		]);

		return response()->json(['status' => true, 'message' => 'announcement made successfully']);

	}
	function random_color_part() {
		return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
	}

	function getHexaCode() {
		return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}

}
