This calls GET API
/api/exchange
with middleware for authentication
( see auth.conf , 'api' secion )

if everything is ok it returns for instance
{"exchange_rate":89.05,"token":"567"}

with token like
--header 'Authorization: Bearer 567'

if it was
--header 'Authorization: Bearer 567)'

it returns invalid format for instance , because open parethesis must be closed

It has contract - interface , according  to Haxagonal architecture
ExchangeRateServiceInterface
interface

There are some test cases
in ExchangeRateApiTest.php