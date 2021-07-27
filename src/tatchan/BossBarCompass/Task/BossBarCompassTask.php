<?php

namespace tatchan\BossBarCompass\Task;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use xenialdan\apibossbar\BossBar;

class BossBarCompassTask extends Task
{
    /** @var BossBar[] */
    private $bossbars = [];

    public function onRun(int $currentTick) {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            $name = $player->getName();
            if (array_key_exists($name, $this->bossbars)) {
                $deg = $player->getYaw();
                $deg %= 360;
                $player->sendMessage((string)$deg);
                $b = $this->bossbars[$name];
                $b->setTitle($this->なんかすごいやつ($player->getYaw()));
                $yaw = $player->getYaw();
                $deg = $yaw % 360;


                $bossbars = [
                    45 * 0 => "N",
                    45 * 1 => "NE",
                    45 * 2 => "E",
                    45 * 3 => "SE",
                    45 * 4 => "S",
                    45 * 5 => "SW",
                    45 * 6 => "W",
                    45 * 7 => "NW",
                ];
                $s = [];

                for ($i = 0; $i < 360; $i += 15) {
                    if ($i % 90 === 0) {
                        $s[] = $bossbars[$i];
                    } else if ($i % 45 === 0) {
                        $s[] = $bossbars[$i];
                    } else {
                        $s[] = $i;
                    }
                }

                $v = implode(" ", $s) . " ";

                $strlen = 40;//取り出す文字数
                $center = $deg * strlen($v) / 360;//中心位置

                $center += strlen($v);
                $v = str_repeat($v, 3);
                $b->setSubTitle(str_repeat(" ", (strlen(substr($v, $center - floor($strlen / 2), $strlen)) / 2) + floor(strlen($deg) / 2)) . $deg);
                $b->setPercentage((float) 1);
                $b->hideFrom([$player]);
                $b->showTo([$player]);
            } else {
                $this->bossbars[$name] = ($b = new BossBar());
                $b->setTitle("たいとる" . $player->getName());
                $b->setSubTitle("サブタイトル");
                $b->addPlayer($player);
            }
        }
    }

    public function なんかすごいやつ(int $yaw) {

        $deg = $yaw % 360;

        $b = [
            45 * 0 => "N",
            45 * 1 => "NE",
            45 * 2 => "E",
            45 * 3 => "SE",
            45 * 4 => "S",
            45 * 5 => "SW",
            45 * 6 => "W",
            45 * 7 => "NW",
        ];
        $s = [];

        for ($i = 0; $i < 360; $i += 15) {
            if ($i % 90 === 0) {
                $s[] = $b[$i];
            } else if ($i % 45 === 0) {
                $s[] = $b[$i];
            } else {
                $s[] = $i;
            }
        }

        $v = implode(" ", $s) . " ";

        $strlen = 40;//取り出す文字数
        $center = $deg * strlen($v) / 360;//中心位置

        $center += strlen($v);
        $v = str_repeat($v, 3);

        return str_replace(array_values($b), ["§l§eN§r", "§eNE§r", "§l§eE§r", "§eSE§r", "§l§eS§r", "§eSW§r", "§l§eW§r", "§eNW§r"], substr($v, $center - floor($strlen / 2), $strlen));

    }
}
