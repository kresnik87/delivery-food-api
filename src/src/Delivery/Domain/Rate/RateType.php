<?php

namespace KsK\Delivery\Domain\Rate;


use KsK\Shared\Domain\ValueObject\Enum;

class RateType extends Enum
{
  const RATE_TYPE_DAILY = "daily";
  const RATE_TYPE_WEEKLY = "weekly";
  const RATE_TYPE_BIWEEKLY = "biweekly";
  const RATE_TYPE_MONTHLY = "monthly";
  const RATE_TYPE_YEARLY = "yearly";


}
