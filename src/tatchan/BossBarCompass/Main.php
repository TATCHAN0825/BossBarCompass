<?php

declare(strict_types=1);

namespace tatchan\BossBarCompass;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use tatchan\BossBarCompass\Task\BossBarCompassTask;

class Main extends PluginBase implements Listener {

public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents($this,$this);
    $this->getScheduler()->scheduleRepeatingTask(new BossBarCompassTask()
    ,1);
}


}
