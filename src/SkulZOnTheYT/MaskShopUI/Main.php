<?php

declare(strict_types=1);

namespace SkulZOnTheYT\MaskShopUI;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
use SkulZOnTheYT\MaskShopUI\Form\{Form, SimpleForm};

class Main extends PluginBase implements Listener {
    
    /** @var Main $instance */
    private static $instance;
	
	public $plugin;

	public function onEnable() : void{
	    self::$instance = $this;
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->saveDefaultConfig();
      $this->getResource("config.yml");
		
      if($this->getConfig()->get("config-ver") != 2)
        {
            $this->getLogger()->info("MaskShopUI's config is NOT up to date. Please delete the config.yml and restart the server or the plugin may not work properly.");
        }
    }
	
	public static function getInstance() : self{
	    return self::$instance;
	}
     
  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
        if($sender instanceof Player){
          if($cmd->getName() == "mask"){
            $this->MaskShopForm($sender);
          }
        } else {
          $sender->sendMessage($this->getConfig()->get("only-ingame"));
        }
        return true;
    }
    
  public function MaskShopForm($sender){
				  $form = new SimpleForm(function (Player $sender, int $data = null){
            $result = $data;
            if ($result === null) {
                return;
            }
            switch ($result) {
                case 0:
				          $sender->sendMessage($this->getConfig()->get("quit.message"));
		    	   		break;
			         	case 1:
				          $this->FeatureMenu($sender);
  				      break;
                case 2:
                  $money = EconomyAPI::getInstance()->myMoney($player);
                    if($money >= $this->getConfig()->get($data)["zombie.prince"]){
                      EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get($data)["zombie.prince"]);
                  $item1 = ItemFactory::getInstance()->get(397, 2, 1);
                  $item1->setCustomName("§2Zombie §eMask \n§bOwner: §c$name");
                  $sender->getInventory()->addItem($item1);
					        $sender->sendMessage($this->getConfig()->get($data)["msg.shop.zombie"]);
                    } else {
                        $sender->sendMessage($this->getCofig()-get($data)["msg.no-money"]);
                      }
                  return true;
			    
                case 3:
                  $money = EconomyAPI::getInstance()->myMoney($player);
                    if($money >= $this->getConfig()->get($data)["creeper.prince"]){
                      EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get($data)["creeper.prince"]);
                  $item2 = ItemFactory::getInstance()->get(397, 4, 1);
                  $item2->setCustomName("§aCreeper §eMask \n§bOwner: §c$name");
                  $sender->getInventory()->addItem($item2);
					        $sender->sendMessage($this->getConfig()->get($data)["msg.shop.creeper"]);
                    } else {
                        $sender->sendMessage($this->getCofig()-get($data)["msg.no-money"]);
                      }
                  return true;
			    
                case 4:
                  $money = EconomyAPI::getInstance()->myMoney($player);
                    if($money >= $this->getConfig()->get($data)["wither.prince"]){
                      EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get($data)["wither.prince"]);
                  $item3 = ItemFactory::getInstance()->get(397, 1, 1);
                  $item3->setCustomName("§7Wither §eMask \n§bOwner: §c$name");
                  $sender->getInventory()->addItem($item3);
                  $sender->sendMessage($this->getConfig()->get($data)["msg.shop.wither"]);
                    } else {
                        $sender->sendMessage($this->getCofig()-get($data)["msg.no-money"]);
                      }
                  return true;
			    
                case 5:
                  $money = EconomyAPI::getInstance()->myMoney($player);
                    if($money >= $this->getConfig()->get($data)["dragon.prince"]){
                      EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get($data)["dragon.prince"]);
                  $item4 = ItemFactory::getInstance()->get(397, 5, 1);
                  $item4->setCustomName("§cDragon §eMask \n§bOwner: §c$name");
                  $sender->getInventory()->addItem($item4);
                  $sender->sendMessage($this->getConfig()->get($data)["msg.shop.dragon"]);
                  } else {
                      $sender->sendMessage($this->getCofig()-get($data)["msg.no-money"]);
                    }
                  return true;
			    
                case 6:
                  $money = EconomyAPI::getInstance()->myMoney($player);
                    if($money >= $this->getConfig()->get($data)["steve.prince"]){
                      EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get($data)["steve.prince"]);
                  $item5 = ItemFactory::getInstance()->get(397, 3, 1);
                  $item5->setCustomName("§3Steve §eMask \n§bOwner: §c$name");
                  $sender->getInventory()->addItem($item5);
                  $sender->sendMessage($this->getConfig()->get($data)["msg.shop.steve"]);
                  } else {
                      $sender->sendMessage($this->getCofig()-get($data)["msg.no-money"]);
                    }
                  return true;
			    
                case 7:
                  $money = EconomyAPI::getInstance()->myMoney($player);
                    if($money >= $this->getConfig()->get($data)["skeleton.prince"]){
                      EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get($data)["skeleton.prince"]);
                  $item6 = ItemFactory::getInstance()->get(397, 0, 1);
                  $item6->setCustomName("§fSkeleton §eMask \n§bOwner: §c$name");
                  $sender->getInventory()->addItem($item6);
                  $sender->sendMessage($this->getConfig()->get($data)["msg.shop.skeleton"]);
                  } else {
                      $sender->sendMessage($this->getCofig()-get($data)["msg.no-money"]);
                    }
                  return true;
            }
        });
      
			$form->setTitle("§eMask §bShop");
			$form->setContent(str_replace(["{name}"], [$sender->getName()], "§fHello §b{name}\n§fFor know the price and the effect you will get when use the mask, you can open the §eMask §dFeatures §fmenu first"));
			$form->addButton("§cExit", 1, "textures/ui/cancel");
			$form->addButton("§l§eMask §dFeatures", 1, "textures/items/nether_stars");
      $form->addButton("§l§2Zombie", 1, "textures/items/zombie_head");
			$form->addButton("§a§lCreeper", 1, "textures/items/creeper_head");
			$form->addButton("§7§lWither Skeleton", 1, "textures/items/wither_skeleton_skull");
			$form->addButton("§c§lDragon", 1, "textures/items/dragon_head");
			$form->addButton("§3§lSteve", 1, "textures/items/player_head");
			$form->addButton("§f§lSkeleton", 1, "textures/items/skeleton_skull");
			$player->sendToPlayer($form);
				},
			)
		);
    }
    
    public function FeatureMenu($sender){
        $form = new SimpleForm(function (Player $sender, int $data = null){
			$result = $data;
			if($result === null){
			  return true;
			}
			switch($result){
				case 0:
				       $this->MaskShopForm($sender);
					break;
				case 1:
				       $sender->sendMessage($this->getConfig()->get("quit.message"));
				    break;
			        }
		        });
		        
		  $zombie = $this->getConfig()->get("zombie.price");
			$wither = $this->getConfig()->get("wither.price");
			$dragon = $this->getConfig()->get("dragon.price");
			$skeleton = $this->getConfig()->get("skeleton.price");
			$creeper = $this->getConfig()->get("creeper.price");
			$steve = $this->getConfig()->get("steve.price"); 
			
      $form->setTitle("§d§lEffects §bList");
      $form->setContent("§6This plugin made by §fSkulZOnTheYT and Kylan1940\n\n§fSkeleton §eMask \n§fPrice: §6$skeleton \n§dEffects: \n§e-§dHaste §7(§bIII§7) §c*Only For 18 Minutes \n§e-§dNight Vision §7(§bIII§7) §c*Only For 18 Minutes \n§e-§dSpeed §7(§bI§7) §c*Only For 18 Minutes \n§e-§dJump Boost §7(§bII§7) §c*Only For 18 Minutes \n\n§2Zombie §eMask \n§fPrice: §6$zombie \n§dEffects: \n§e-§dStrength §7(§bI§7) \n§e-§dNight Vision §7(§bII§7) \n§e-§dJump Boost  §7(§bI§7) \n§e-§dRegeneration §7(§bI§7) \n§e-§dFire Resistance §7(§bI§7) \n\n§aCreeper §eMask \n§fPrice: §6$creeper \n§dEffects: \n§e-§dJump Boost §7(§bII§7) \n§e-§dStrength §7(§bII§7) \n§e-§dNight Vision §7(§bII§7) \n§e-§dRegeneration §7(§bII§7) \n§e-§dFire Resistance §7(§bI§7) \n§e-§dSpeed §7(§bI§7) \n\n§7Wither Skeleton §eMask \n§fPrice: §6$wither \n§dEffects: \n§e-§dSpeed §7(§bI§7) \n§e-§dStrength §7(§bIII§7) \n§e-§dRegeneration \n§7(§bI§7) \n§e-§dHealth Boost §7(§bI§7) \n§e-§dFire Resistance §7(§bII§7) \n§e-§dJump Boost §7(§bIII§7) \n§e-§dNight Vision §7(§bIII§7) \n\n§3Steve §eMask \n§fPrice: §6$steve \n§dEffects: \n§e-§dStrength §7(§bIII§7) \n§e-§dSpeed §7(§bII§7) \n§e-§dRegeneration §7(§bIII§7) \n§e-§dHealth Boost §7(§bV§7) \n§e-§dNight Vision §7(§bIII§7) \n§e-§dFire Resistance §7(§bIV§7) \n§e-§dJump Boost §7(§bIII§7) \n\n§cDragon §eMask \n§fPrice: §6$dragon \n§dEffects: \n§e-§dFire Resistance §7(§bIV§7) \n§e-§dJump Boost §7(§bIII§7) \n§e-§dHealth Boost §7(§bV§7) \n§e-§dSpeed §7(§bIII§7) \n§e-§dNight Vision §7(§bIII§7) \n§e-§dAbsorption §7(§bIII§7) \n§e-§dStrength §7(§bIII§7) \n§e-§dSaturation §7(§bIII§7) \n§e-§dRegeneration §7(§bIII§7)"); 
      $form->addButton("§l§aBACK", 1);
      $form->addButton("§l§cEXIT", 2);
      $form->sendToPlayer($sender);
   }
}
