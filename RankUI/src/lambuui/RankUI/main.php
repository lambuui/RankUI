<?php
declare(strict_types=1);
namespace Milly\RankUI;

# declare(strict_types=1) is not needed but I just put it for the heck of it

use _64FF00\PurePerms\PurePerms;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command, CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

# Using PurePerms as a base to update user's ranks
# PurePerms is not NEEDED as you can use your own permission plugin. Some examples are HRK by CortexPE (Trust Worthy)

class main extends PluginBase implements Listener{
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer->sendMessage("The server is online");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch ($command->getName()){
            case "rankup":
                if($sender instanceof Player){
                    $this->rank($sender);
                }
        }
        return true;
    }

    public function rank($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $perm = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
        $cort = $perm->getUserDataMgr()->getGroup($player)->getName();
        $money = EconomyAPI::getInstance()->myMoney($player);
        $form = $api->createSimpleForm(function (Player $player, int $data = null) use ($cort){
            $result = $data;
            if($result === null){
                return true;
            }
            var_dump($d = 1);
            switch($result){
                case 0:
                    $perm = $this->getServer()->getPluginManager()->getPlugin("PurePerms");

                    $a = $perm->getGroup("A");
                    $b = $perm->getGroup("B");
                    $c = $perm->getGroup("C");
                    $guest = $perm->getGroup("Guest");
                    var_dump(++$d);
                    $money = EconomyAPI::getInstance()->myMoney($player);
                    if($cort == $guest->getName()) {
                        var_dump(++$d);
                        if ($money >= 3000) {
                            var_dump(++$d);
                            EconomyAPI::getInstance()->reduceMoney($player, (float)"3000");
                            $perm->setGroup($player, $a);
                            $player->sendMessage(C::DARK_AQUA . "Your Rank has been Upgraded!");
                            $player->addTitle(C::AQUA . "Welcome to A Rank");
                            return true;
                        } else {
                            var_dump(++$d);
                            $player->sendMessage(C::AQUA . "You do not have enough money!");
                            var_dump($result);
                            return true;
                        }
                    }
                    if($cort == $a->getName()){
                        var_dump(++$d);
                        if($money >= 6000){
                            var_dump(++$d);
                            EconomyAPI::getInstance()->reduceMoney($player, (float)"6000");
                            $perm->setGroup($player, $b);
                            $player->sendMessage(C::DARK_AQUA . "Your Rank has been Upgraded!");
                            $player->addTitle(C::AQUA . "Welcome to B Rank");
                            return true;
                        } else {
                            var_dump(++$d);
                            $player->sendMessage(C::AQUA . "You do not have enough money!");
                            var_dump($result);
                            return true;
                        }
                    }

                    if($cort == $b->getName()){
                        var_dump(++$d);
                        if($money >= 9000){
                            var_dump(++$d);
                            EconomyAPI::getInstance()->reduceMoney($player, (float)"6000");
                            $perm->setGroup($player, $c);
                            $player->sendMessage(C::DARK_AQUA . "Your Rank has been Upgraded!");
                            $player->addTitle(C::AQUA . "Welcome to C Rank");
                            return true;
                        } else {
                            var_dump(++$d);
                            $player->sendMessage(C::AQUA . "You do not have enough money!");
                            var_dump($result);
                            return true;
                        }
                    }
                    if($cort = $c->getName()){
                        $player->sendMessage(C::AQUA . "You Have The Highest Rank!");
                        return true;
                    }
                    break;

                case 1:

                    break;
            }
            return true;
        });
        $form->setTitle("§1§bRank§rUP");
        $form->setContent("§dYour Rank§7[" . $cort . "§7]\n§bYour Money: §e$" . $money . "");
        $form->addButton("§bUpgrade Rank!");
        $form->addButton("Close");
        $form->sendToPlayer($player);
        return true;
    }
}

