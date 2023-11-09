<?php
use App\Models\Location;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class LocationController implements MessageComponentInterface
{
    protected $connections;

    public function __construct()
    {
        $this->connections = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $connection)
    {
        $this->connections->attach($connection);
        dd('a2sdf');
    }

    public function onMessage(ConnectionInterface $from, $message)
    {
        $data = json_decode($message);
        dd('asdf');

        if ($data->action === 'getLatestLocation') {
            $latestLocation = $this->getLatestLocation();

            $from->send(json_encode(['location' => $latestLocation]));
        }
    }

    public function onClose(ConnectionInterface $connection)
    {
        $this->connections->detach($connection);
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        print($e);
        $connection->close();
    }

    private function getLatestLocation()
    {
        $latestLocation = Location::with('device')
            ->latest('created_at')
            ->first();

        return $latestLocation;

    }
}
