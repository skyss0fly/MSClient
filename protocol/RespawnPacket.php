<?php

declare(strict_types=1);


namespace protocol;


use pocketmine\math\Vector3;

class RespawnPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::RESPAWN_PACKET;

	/** @var Vector3 */
	public $position;

	function decodePayload() : void{
		$this->position->x = $this->getLFloat();
		$this->position->y = $this->getLFloat();
		$this->position->z = $this->getLFloat();
	}

	function encodePayload() : void{
		$this->putLFloat($this->position->x);
		$this->putLFloat($this->position->y);
		$this->putLFloat($this->position->z);
	}
}
