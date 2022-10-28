<?php

declare(strict_types=1);

namespace PullDK\KillMoney;

use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\event\Listener;

class Main extends PluginBase{


        public function onEnable(): void
        {
            $this->getServer()->getPluginManager()->registerEvents($this, $this);
            $this->saveResource();
        }
    
        public static function addMoney(Player $player, int $amount)
        {
            $facapi = Server::getInstance()->getPluginManager()->getPlugin("BedrockEconomy")->getDataFolder() . "cooldogedev/BedrockEconomy/api/version" . strtolower("LegacyBEAPI") . ".php";
            return $facapi->addToPlayerBalance($player->getName(), $amount);
        }
    
        public function onAttack(PlayerDeathEvent $event)
        {
            $damageCause = $event->getEntity()->getLastDamageCause();
    
            if (!$damageCause instanceof EntityDamageByEntityEvent) return;
            /** @var EntityDamageByEntityEvent $damageCause */
    
            if (!$damageCause->getDamager() instanceof Player) return;
    
            /** @var Player $damager */
            $damager = $damageCause->getDamager();
            self::addMoney($damager, $this->getConfig()->get("moneyadd"));
        }
    

}
