<?php

namespace Angga7Togk\Haste;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\effect\EffectInstance;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase{
	
	public function onEnable() : void{
		
		 @mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->getResource("config.yml");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
		
		switch($cmd->getName()){
			case "haste":
				if($sender instanceof Player){
					if(isset($args[0])){
						switch(strtolower($args[0])){
							case "on":
								if(!$sender instanceof Player){
									$sender->sendMessage("Please use command in game");
									return true;
								}
								if($sender->hasPermission("haste.command")){
									$sender->getEffects()->add(new EffectInstance(VanillaEffects::HASTE(), 20 * $this->getConfig()->get("Effect")["Time"]["Second"], 2, true));
									$sender->sendMessage($this->getConfig()->get("Effect")["Message"]["Enable"]);
									return true;
								}
							break;
							
							case "off":
								if(!$sender instanceof Player){
									$sender->sendMessage("Please use command in game");
									return true;
								}
								if($sender->hasPermission("haste.command")){
									if($sender->getEffects()->has(VanillaEffects::HASTE())){
										$sender->getEffects()->remove(VanillaEffects::HASTE());
										$sender->sendMessage($this->getConfig()->get("Effect")["Message"]["Disable"]);
									}
									return true;
								}
							break;
						}
					} else {
						$sender->sendMessage("please type /haste [on, off]");
					}
				}
			}
		return true;
	}
}

