<?php

/**
 * Created by PhpStorm.
 * User: MakStashkevich
 * Date: 10.03.2019
 * Time: 15:20
 */

namespace console;

use client\BotHelpers;
use client\Client;
use pocketmine\math\Vector3;

class Console
{
	/** @var */
	private $console;

	/** @var Client */
	private $client;

	/** @var bool */
	private $chat = false;

	/**
	 * Console constructor.
	 * @param Client $client
	 * @param bool $chat
	 */
	function __construct(Client $client, bool $chat = false)
	{
		$this->client = $client;
		$this->console = new ConsoleReader();
		$this->chat = $chat;
	}

	function tick()
	{
		if (($line = $this->console->getLine()) !== null) {
			$this->command($line);
		}
	}

	/**
	 * @param string $command
	 */
	function command(string $command)
	{
		$args = explode(' ', $command);
		switch ($args[0]) {
			case 'stop':
				$this->client->stop();
				break;
			case 'connect':
				if (!isset($args[1])) {
					info('You didn\'t specify a bot id!');
					break;
				}
				$this->chat = $this->client->setClientId((int)$args[1]);
				break;
			case 'disconnect':
				$this->client->removeClientId();
				$this->chat = false;
				break;
			case 'move':
				$client = $this->client->getPocketClient();
				if ($client === false) break;
				if (!isset($args[1]) || !is_numeric($args[1])) {
					info('U don\'t write X');
					break;
				}
				if (!isset($args[2]) || !is_numeric($args[2])) {
					info('U don\'t write Y');
					break;
				}
				if (!isset($args[3]) || !is_numeric($args[3])) {
					info('U don\'t write Z');
					break;
				}
				BotHelpers::moveTo($client, new Vector3((float)$args[1], (float)$args[2], (float)$args[3]));
				break;
			case 'up':
				$client = $this->client->getPocketClient();
				if ($client === false) break;
				if (!isset($args[1]) || !is_numeric($args[1])) {
					info('U don\'t write UP coords');
					break;
				}
				BotHelpers::moveTo($client, $client->getPlayer()->getPosition()->add(0, (float)$args[1]));
				break;
			case "attack":
				$client = $this->client->getPocketClient();
				if ($client === false) break;
				if (!isset($args[1]) || !is_numeric($args[1])) {
					info('put a entity id');
					break;
				}
				if (!isset($args[2]) || !is_string($args[2])) {
					info('put true or false to show hand animation or not');
					return;
				}
				if ($args[2] === "true") {
					$pk = new AnimatePacket();
					$pk->entityRuntimeId = $client->getId();
					$pk->action = AnimatePacket::ACTION_SWING_ARM;
					$client->sendDataPacket($pk);
				}

				$pk = new EntityEventPacket();
				$pk->entityRuntimeId = (int)$args[1];
				$pk->event = EntityEventPacket::HURT_ANIMATION;
				$client->sendDataPacket($pk);
				$client->damage($args[1]);
//				BotHelpers::lookAt($client->getPlayer()->getPosition(), $client->get);
				break;
			default:
				if ($this->chat) $this->client->chat($command);
				break;
		}
	}
}
