<?php

namespace Staff;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\entity\{Effect, EffectInstance, Entity};
use pocketmine\Player;
use UIAPI\{Form, ModalForm, SimpleForm, CustomForm};
use UIS\KickUI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

class StaffMode extends PluginBase implements Listener {
	
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);    
        $this->getLogger()->info(TextFormat::GREEN . "StaffMode Activate By Callum");
    }
    public function onDisable() {
        $this->getLogger()->info(TextFormat::RED . "StaffMode Deactivate By Callum");
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "staff":
                if ($sender->hasPermission("staff.command")){
                     $this->Menu($sender);
                }else{     
                     $sender->sendMessage(TextFormat::RED . "§You do not have permission to use the staff");
                     return true;
                }     
            break;         
            
         }  
        return true;                         
    }
   
    public function Menu($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null){
            $result = $data;
            if($result === null){
			return true;
            }             
            switch($result){
                case 0:
                    $this->GMUI($sender);
                break;   
               case 1:
                    $this->VanishUI($sender);
                break;   
               case 2:
$this->getServer()->dispatchCommand($sender, "tban");
                break;   
               case 3:
$this->getServer()->dispatchCommand($sender, "admin");
                break;   
               case 4:
$this->getServer()->dispatchCommand($sender, "staffchat");
                 break;   
               case 5:
$this->getServer()->dispatchCommand($sender, "freeze");
                break;   
               case 6:
$this->getServer()->dispatchCommand($sender, "teleport");
                break;          
            }
        });
        $form->setTitle("§f§lStaffTools");
        $form->setContent("§7StaffMode  §b@CallumRawlinson");
        $form->addButton("§l§eGamemode\n§r§0Select",0,"textures/ui/conduit_power_effect");
        $form->addButton("§l§bVanish\n§r§0Select",0,"textures/ui/invisibility_effect");
        $form->addButton("§l§cBan\n§r§0Select",0,"textures/ui/resistance_effect");
        $form->addButton("§l§6Kick\n§r§0Select",0,"textures/ui/mute_off");
        $form->addButton("§l§9StaffChat\n§r§0Select",0,"textures/items/paper");
        $form->addButton("§l§dFreeze\n§r§0Select",0,"textures/ui/FriendsIcon");
        $form->addButton("§l§4Teleport\n§r§0Select",0,"textures/ui/icon_multiplayer");
        $form->sendToPlayer($sender);
            return $form;
    }
    
    public function GMUI($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
            $command = "staff" ;
            $this->getServer()->getCommandMap()->dispatch($sender, $command);
                break;
                case 1:
            $sender->setGamemode(0);
            $sender->addTitle("§cSurvival", "");
                break;
                case 2:
            $sender->setGamemode(1);
            $sender->addTitle("§eCreative", "");
                break;
                case 3:
            $sender->setGamemode(2);
            $sender->addTitle("§cAdventure", "");
                break;
                case 4:
            $sender->setGamemode(3);
            $sender->addTitle("§eSpectator", "");
                break;

                }
            });
            $form->setTitle("§e§lGAMEMODEUI");
            $form->addButton("§4§lGo\n§r§0Back",0,"textures/ui/refresh_light");
            $form->addButton("§c§lSurvival\n§r§0Tap To Choose");
            $form->addButton("§e§lCreative\n§r§0Tap To Choose");
            $form->addButton("§c§lAdventure\n§r§0Tap To Choose");
            $form->addButton("§e§lSpectator\n§r§0Tap To Choose");
            $form->sendToPlayer($sender);
            return $form;
    }
    
    public function VanishUI($sender){
      	$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
            $command = "staff" ;
            $this->getServer()->getCommandMap()->dispatch($sender, $command);
                break;
                    case 1:
			$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
			$sender->setNameTagVisible(false);
			$sender->addTitle("§aVanish", "§7Activate");
                        break;
                    case 2:
                    	$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
			$sender->setNameTagVisible(true);
			$sender->addTitle("§cVanish", "§7Deactivate");
                        break;
                    	
            }
        });
        $form->setTitle("§b§lVanish");
            $form->addButton("§4§l\n§r§0Go Back",0,"textures/ui/refresh_light");
            $form->addButton("§b§lVanish §aON\n§r§0Tap To Activate",0,"textures/ui/confirm");
            $form->addButton("§b§lVanish §cOFF\n§r§0Tap To Deactivate",0,"textures/ui/cancel");
        $form->sendToPlayer($sender);
    }
}
