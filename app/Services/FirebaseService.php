<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $credentialsPath = base_path('firebase_credentials.json');
        
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Firebase credentials file not found at: ' . $credentialsPath);
        }

        $firebase = (new Factory)
            ->withServiceAccount($credentialsPath)
            ->createMessaging();

        $this->messaging = $firebase;
    }

    /**
     * Send notification to specific device
     */
    public function sendToDevice($deviceToken, $title, $body, $data = [])
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withData($data);

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            \Log::error('Firebase send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification to multiple devices
     */
    public function sendToMultipleDevices($deviceTokens, $title, $body, $data = [])
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data);

        try {
            $this->messaging->sendMulticast($message, $deviceTokens);
            return true;
        } catch (\Exception $e) {
            \Log::error('Firebase multicast failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification to topic
     */
    public function sendToTopic($topic, $title, $body, $data = [])
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)
            ->withData($data);

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            \Log::error('Firebase topic send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Subscribe device to topic
     */
    public function subscribeToTopic($deviceTokens, $topic)
    {
        try {
            $this->messaging->subscribeToTopic($deviceTokens, $topic);
            return true;
        } catch (\Exception $e) {
            \Log::error('Firebase subscribe failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Unsubscribe device from topic
     */
    public function unsubscribeFromTopic($deviceTokens, $topic)
    {
        try {
            $this->messaging->unsubscribeFromTopic($deviceTokens, $topic);
            return true;
        } catch (\Exception $e) {
            \Log::error('Firebase unsubscribe failed: ' . $e->getMessage());
            return false;
        }
    }
}