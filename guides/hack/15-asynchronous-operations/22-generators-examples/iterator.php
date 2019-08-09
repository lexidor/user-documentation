<?hh // strict

namespace Hack\UserDocumentation\AsyncOps\Generators\Examples\Iterator;

require __DIR__."/../../../../vendor/hh_autoload.php";

const int SECOND = 1000000; // microseconds

async function countdown(int $from): AsyncIterator<int> {
  for ($i = $from; $i >= 0; --$i) {
    await \HH\Asio\usleep(SECOND);
    // Every second, a value will be yielded back to the caller, happy_new_year()
    yield $i;
  }
}

async function happy_new_year(int $start): Awaitable<void> {
  // Get the AsyncIterator that enables the countdown
  $ait = countdown($start);
  foreach ($ait await as $time) {
    // we are awaiting the returned awaitable, so this will be an int
    if ($time > 0) {
      echo $time."\n";
    } else {
      echo "HAPPY NEW YEAR!!!\n";
    }
  }
}

<<__EntryPoint>>
function run(): void {
  \HH\Asio\join(happy_new_year(5)); // 5 second countdown
}
