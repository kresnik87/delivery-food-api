<?php

namespace Essedi\EasyCommerce\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Notification;
use App\Entity\NotificationUser;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;
use RedjanYm\FCMBundle\FCMClient;
use sngrl\PhpFirebaseCloudMessaging\Client;
use Twig\Environment;
use Essedi\EasyCommerce\Utils\StrUtils;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Swift_Message;
use Swift_Mailer;
use Swift_Attachment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class NotificationGenerator
{

    const NOTIFICATION_WELCOME      = "notif_trans.welcome";
    const NOTIFICATION_REGISTER     = "notif_trans.register";
    const NOTIFICATION_ORDER_CREATE = "notif_trans.order.create";

    /**
     * @var EntityManagerInterface 
     */
    protected $em;

    /**
     * @var Translator 
     */
    protected $translator;

    /**
     * @var string 
     */
    protected $defaultLocale = null;

    /**
     * @var MailerInterface | Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var StrUtils
     */
    protected $strUtils;

    /**
     *
     * @var ParameterBagInterface
     */
    protected $parameters;

    /**
     * 
     * @param EntityManagerInterface $entityManager
     * @param Translator $translator
     * @param string $defaultLocale
     * @param MailerInterface | Swift_Mailer $mailer
     * @param Environment $twig
     * @param StrUtils $strUtils 
     * @param ParameterBagInterface $params
     */
    public function __construct(
            EntityManagerInterface $entityManager,
            Translator $translator,
            string $defaultLocale,
            Swift_Mailer $mailer,
            Environment $twig,
            StrUtils $strUtils,
            ParameterBagInterface $params)
    {
        $this->em            = $entityManager;
        $this->translator    = $translator;
        $this->defaultLocale = $defaultLocale;
        $this->mailer        = $mailer;
        $this->twig          = $twig;
        $this->strUtils      = $strUtils;
        $this->params        = $params;
    }

    protected function getWelcomeNotification($options = [])
    {
        //check if exist
        if ($this->params->get("essedi_easy_commerce.notifications.persist"))
        {
            $notif = $this->em->getRepository(Notification::class)->findOneByName(self::NOTIFICATION_WELCOME);
            if ($notif)
            {
                return $notif;
            }
        }
        //create 
        $notif = new Notification;
        $notif->setName(self::NOTIFICATION_WELCOME);
        $notif->setTitle(self::NOTIFICATION_WELCOME . ".title");
        $notif->setDescription(self::NOTIFICATION_WELCOME . ".description");

        $this->em->persist($notif);
        if ($this->emFlush($options))
        {
            $this->em->flush();
        }

        return $notif;
    }

    public function getWelcomeName()
    {
        return self::NOTIFICATION_WELCOME;
    }

    protected function getRegisterNotification($options = [])
    {
        //check if exist
        if ($this->params->get("essedi_easy_commerce.notifications.persist"))
        {
            $notif = $this->em->getRepository(Notification::class)->findOneByName(self::NOTIFICATION_REGISTER);
            if ($notif)
            {
                return $notif;
            }
        }
        //create 
        $notif = new Notification;
        $notif->setName(self::NOTIFICATION_REGISTER);
        $notif->setTitle(self::NOTIFICATION_REGISTER . ".title");
        $notif->setDescription(self::NOTIFICATION_REGISTER . ".description");

        $this->em->persist($notif);
        if ($this->emFlush($options))
        {
            $this->em->flush();
        }

        return $notif;
    }

    public function getRegisterName()
    {
        return self::NOTIFICATION_REGISTER;
    }

    public function getOrderCreateName()
    {
        return self::NOTIFICATION_ORDER_CREATE;
    }

    protected function getTemplateNotificataion($name)
    {
        return $this->em->getRepository(Notification::class)->findOneByName($name);
    }

    public function sendNotification(Notification $not, $options = [])
    {
        if ($not->sendMail())
        {
            $emails = [];
            //get users
            foreach ($not->getUsers()as $user)
            {

                if ($user->wantsNotifications($not->getTypes()))
                {
                    if (!in_array($user->getEmail(), $emails))
                    {
                        $emails[] = $user->getEmail();
                    }
                }
            }
            //get mails
            foreach ($not->getMails() as $mail)
            {
                if (!in_array($mail, $emails))
                {
                    $emails[] = $mail;
                }
            }

            if (count($emails))
            {
                $this->sendMailTranslate($not->getTitle(), $not->getDescription(), $emails);
            }
        }
        if ($not->sendPush())
        {
            $tokens = [];
            //get devices
            foreach ($not->getDevices() as $device)
            {
                if ($device->getUser() && $device->getUser()->wantsNotifications($not->getTypes()))
                {
                    if (!in_array($device->getToken(), $tokens))
                    {
                        $tokens[] = $device->getToken();
                    }
                }
            }

            //get tokens
            foreach ($not->getTokens() as $token)
            {
                if (!in_array($token, $tokens))
                {
                    $tokens[] = $token;
                }
            }

            //get users
            foreach ($not->getUsers()as $user)
            {

                if ($user->wantsNotifications($not->getTypes()))
                {
                    foreach ($user->getDevicesToken() as $token)
                    {
                        if (!in_array($token, $tokens))
                        {
                            $tokens[] = $token;
                        }
                    }
                }
            }
            if (count($tokens))
            {
                $this->sendPushTranslate($not->getTitle(), $not->getDescription(), $tokens, $this->defaultLocale, $not->getParams());
            }

            //send to all
            if ($not->getTopics())
            {
                $this->sendPushToTopic($not->getTitle(), $not->getDescription(), $not->getParams(), $not->getTopics());
            }
        }
        if ($not->sendEntity())
        {
            //get users
            foreach ($not->getUsers()as $user)
            {

                if ($user->wantsNotifications($not->getTypes()))
                {
                    //create relation
                    //create notification user
                    $notifUser = new NotificationUser;
                    $notifUser->setNotification($not);
                    $notifUser->setUser($user);
                    $this->em->persist($notifUser);
                }
            }
            if ($this->emFlush($options))
            {
                $this->em->flush();
            }
        }
    }

    /**
     * 
     * @param type $user
     * @param type $name
     * @param string $title
     * @param string $description
     * @param array $options 
     *          template string  Uses template to generate notification content
     *          flush   bool    Flush Notification when creates (Needs disable on listeners)
     *          autolables bool  Create title and descrition label to translate by name
     * @return Notification|null
     */
    public function createNotifToUser($user, $name, $title = null, $description = null, $options = []): ?Notification
    {
        //find user 
        //check if exist
        if (!($user instanceof User))
        {
            $user = $this->em->getRepository(User::class)->find($user);
        }
        if ($options && isset($options["template"]) && $options["template"])
        {
            switch ($options["template"])
            {
                case self::NOTIFICATION_WELCOME:
                    $notif = $this->getWelcomeNotification($options);
                    break;
                case self::NOTIFICATION_REGISTER:
                    $notif = $this->getRegisterNotification($options);
                    break;
                default:
                    $notif = $this->getTemplateNotificataion($options["template"]);
                    break;
            }
        }
        else
        {
            //create  notification
            $notif = new Notification;
            $notif->setName($name);
            $notif->setTranslation($name, "name");
            if ($options && isset($options["autolabels"]) && $options["autolabels"])
            {
                $title       = $name . '.title';
                $description = $name . '.description';
            }
            $notif->setTitle($title);
            $notif->setTranslation($title, "title");
            $notif->setDescription($description);
            $notif->setTranslation($description, "description");
            if ($options && isset($options["params"]) && $options["params"])
            {
                $notif->setParams($options["params"]);
            }
            $this->em->persist($notif);
            if ($this->emFlush($options))
            {
                $this->em->flush($notif);
            }
        }
        //create relation
        $notifUser = new NotificationUser;
        $notifUser->setNotification($notif);
        $notifUser->setUser($user);

        $this->em->persist($notifUser);
        if ($this->emFlush($options))
        {
            $this->em->flush($notifUser);
        }

        if (!isset($options["push"]) || $options["push"] !== false)
        {
            //send push
            $devices = $user->getDevices();
            $langs[] = [
            ];

            if ($devices)
            {
                foreach ($devices as $device)
                {
                    if (!isset($langs[$device->getLang() ? $device->getLang() : $this->defaultLocale]))
                    {
                        $langs[$device->getLang() ? $device->getLang() : $this->defaultLocale] = [
                        ];
                    }
                    $langs[$device->getLang() ? $device->getLang() : $this->defaultLocale][] = $device->getToken();
                }

                foreach ($langs as $lang => $tokens)
                {
                    if ($tokens && count($tokens))
                    {
                        $result[] = $this->sendPushTranslate(strip_tags($notif->getTitle()), strip_tags($notif->getDescription()), $tokens, $lang, $notif->getParams());
                    }
                }
            }
        }

        if (!isset($options["mail"]) || $options["mail"] !== false)
        {
            //send mail
            $this->sendMailTranslate($notif->getTitle(), $notif->getDescription(), $user->getEmail(), $this->defaultLocale, $notif->getParams());
        }

        return $notif;
    }

    /**
     * Translate labels before send push
     * @param type $title
     * @param type $description
     * @param type $token
     * @param type $lang
     * @param array $parameters
     * @return sendPush
     */
    public function sendPushTranslate($title, $description, $token, $lang = null, $parameters = [])
    {
        if (!$parameters)
        {
            $parameters = [
            ];
        }

        $title       = $this->translator->trans($title, $parameters, null, $lang);
        $description = $this->translator->trans($description, $parameters, null, $lang);
        return $this->sendPush($title, $description, $parameters, $token);
    }

    /**
     * sends push
     * @param string $title
     * @param string $description
     * @param string|array $token
     * @return type
     */
    public function sendPush($title, $description, $params = [], $token)
    {
        $apiKey = $this->params->get("redjan_ym_fcm.firebase_api_key");
        if (!$apiKey || strtoupper($apiKey) == "FALSE" || $apiKey == '^')
        {
            return null;
        }
        $fcmClient    = new FCMClient((new Client())->setApiKey($apiKey));
        $notification = $fcmClient->createDeviceNotification(strip_tags($title), strip_tags($description), $token);
        $notification->addData("vibrate", [
            500,
            300,
            500]);
        $notification->addData("icon", 'ic_notification');
        foreach ($params as $key => $value)
        {
            $notification->addData($key, $value);
        }

        return $fcmClient->sendNotification($notification);
    }

    /**
     * sends push to all devices was suscribed to topic by notifications config
     * @param string $title
     * @param string $description
     * @param string|array $topics 
     * @return type
     */
    public function sendPushToTopic($title, $description, $params = [], $topics)
    {
        $apiKey = $this->params->get("redjan_ym_fcm.firebase_api_key");
        if (!$apiKey || strtoupper($apiKey) == "FALSE" || $apiKey == '^')
        {
            return null;
        }
        $fcmClient = new FCMClient((new Client())->setApiKey($apiKey));
//        firebase planned to add send push to some topics but now do not 
        if (!is_array($topics))
        {
            $topics = [$topics];
        }
        $result = [];
        foreach ($topics as $topic)
        {
            $notification = $fcmClient->createTopicNotification($this->cleanText($title), $this->cleanText($description), $topic);
            $notification->addData("vibrate", [
                500,
                300]);
            foreach ($params as $key => $value)
            {
                $notification->addData($key, $value);
            }

            $result = $fcmClient->sendNotification($notification);
        }

        return $result;
    }

    /**
     * Sets subcribe to all user devices
     * @param string $topic
     * @param User $user
     * @return $this
     */
    public function subscribeUserToTopic(string $topic, User $user)
    {
        $tokens = $user->getDevicesToken();
        if ($tokens && count($tokens))
        {
            $this->subscribeToTopic($topic, $tokens);
        }
        return $this;
    }

    /**
     * Sets unsubcribe to all user devices
     * @param string $topic
     * @param User $user
     * @return $this
     */
    public function unsubscribeUserToTopic(string $topic, User $user)
    {
        $tokens = $user->getDevicesToken();
        if ($tokens && count($tokens))
        {
            $this->unsubscribeToTopic($topic, $tokens);
        }
        return $this;
    }

    /**
     * Subcribe one Device to topic
     * @param string $topic
     * @param string| string[] $token
     * @return $this
     */
    public function subscribeToTopic($topic, $token)
    {
        $fcmClient = new FCMClient((new Client())->setApiKey($this->params->get("redjan_ym_fcm.firebase_api_key")));
        $fcmClient->removeDevicesFromTopic($topic, $token);
        return $this;
    }

    /**
     * Unsubcribe one Device to topic
     * @param string $topic
     * @param string| string[] $token
     * @return $this
     */
    public function unsubscribeToTopic($topic, $token)
    {
        $fcmClient = new FCMClient((new Client())->setApiKey($this->params->get("redjan_ym_fcm.firebase_api_key")));
        $fcmClient->removeDevicesFromTopic($topic, $token);
        return $this;
    }

    /**
     * Translate labels before send push
     * @param type $title
     * @param type $description
     * @param type $mail
     * @param type $lang
     * @param array $parameters
     * @return sendPush
     */
    public function sendMailTranslate($title, $description, $mail, $lang = null, $parameters = [], $attachments = [])
    {
        if (!$parameters)
        {
            $parameters = [
            ];
        }
        $title       = $this->translator->trans($title, $parameters, null, $lang);
        $description = $this->translator->trans($description, $parameters, null, $lang);
        //load template
        $data        = ['subject' => $title, 'body' => $description];

        if ($this->twig->getLoader()->exists("@Templates/mail/index.html.twig"))
        {
            $body = $this->twig->render("@Templates/mail/index.html.twig", $data);
        }
        else
        {
            $body = $this->twig->render('@EssediEasyCommerce/mail/index.html.twig', $data);
        }
        return $this->sendMail($mail, $title, $body, null, $attachments);
    }

    /**
     * 
     * @param string|string[] $receivers destinations email(s)
     */
    public function sendMail($receivers, $title, $description, $sender = null, $attachments = null)
    {

        if (class_exists('Swift_Mailer'))
        {
            if ($sender == null)
            {
                $sender = [$this->params->get("mailer.user") => $this->params->get("mailer.name")];
            }

            $message = new Swift_Message($title);
            $message->setFrom($sender);
            $message->setBcc($receivers);
            $message->setBody($description, 'text/html');
            if ($attachments && count($attachments))
            {
                foreach ($attachments as $attachment)
                {
                    $message->attach(Swift_Attachment::fromPath($attachment));
                }
            }
        }
        else
        {
            if ($sender == null)
            {
                $sender = new Address($this->params->get("mailer.user"), $this->params->get("mailer.name"));
            }
            $message = new Email();

            $message->subject($title);
            $message->from($sender);
            $message->bcc($receivers);
            $message->html($description);
            if ($attachments && count($attachments))
            {
                foreach ($attachments as $attachment)
                {
                    $message->attachFromPath($attachment);
                }
            }
        }


        $this->mailer->send($message);

        return $message;
    }

    protected function emFlush($options): bool
    {
        if ($options && isset($options["flush"]) && !$options["flush"])
        {
            return false;
        }
        return true;
    }

    /**
     * Converts OrderStatus on new Notification
     * @param Order $order
     * @param bool $autoflush
     * @return Notification
     */
    public function orderStatusNotification(Order $order, bool $autoflush = false): Notification
    {
        $name    = $order->getStatus()->getName();
        $title   = $order->getStatus()->getTitle();
        $rawDesc = $order->getStatus()->getDescription();

        //create  notification
        $notif = new Notification();
        $notif->setName($name);
        $notif->setTranslation($name, "name");
        $notif->setTitle($title);
        $notif->setTranslation($title, "title");

        if ($order->getUser())
        {
            $notif->addUser($order->getUser());
        }

        //adds too email if is disntint as user mail
        $mails = [];
        if ($order->getUser())
        {
            if (!in_array($order->getUser()->getEmail(), $mails))
            {
                $mails[] = $order->getUser()->getEmail();
            }
        }
        if ($order->getCustomer())
        {
            in_array($order->getCustomer()->getEmail(), $mails);
            if ($order->getCustomer()->getAddress())
            {
                if (!in_array($order->getCustomer()->getAddress()->getEmail(), $mails))
                {
                    $mails[] = $order->getCustomer()->getAddress()->getEmail();
                }
            }
        }

        if ($order->getShippingAddress())
        {
            if (!in_array($order->getShippingAddress()->getEmail(), $mails))
            {
                $mails[] = $order->getShippingAddress()->getEmail();
            }
        }
        if ($mails && count($mails))
        {
            foreach ($mails as $mail)
            {
                if ($mail)
                {
                    $notif->addMail($mail);
                }
            }
        }


        if ($rawDesc && strlen($rawDesc))
        {
            $description = $this->strUtils->replaceBrackets($rawDesc, $this->getOrderStatusParams($order));
        }
        else
        {
            $description = $rawDesc;
        }

        $notif->setDescription($description);
        $notif->setTranslation($description, "description");

        $this->em->persist($notif);
        if ($autoflush)
        {
            $this->em->flush($notif);
        }
        return $notif;
    }

    protected function getOrderStatusParams(Order $order)
    {
        $params                            = [];
        $params["order.code"]              = $order->getCode();
        $params["order.customer.name"]     = '';
        $params["order.customer.surnames"] = '';

        if ($order->getCustomer())
        {
            $params["order.customer.name"]     = $order->getCustomer()->getName();
            $params["order.customer.surnames"] = $order->getCustomer()->getSurnames();
        }
        return $params;
    }

    /**
     * Convert  html to plain string 
     * @param string $text
     * @return string
     */
    public function cleanText(string $text = ''): string
    {
        return trim(preg_replace('/\s\s+/', ' ', html_entity_decode(strip_tags($text))));
    }

}
