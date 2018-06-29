1. Install multichain from https://www.multichain.com/

2. Create a chain using command prompt "multichain-util create [chain-name]"

3. Run daemon "multichaind [chain-name] -daemon"

4. Connect to this chain using "multichaind -datadir=[data directory where you want create the node] [chain-name]@[IP:Port] -daemon"  (Ip and Port will be available from the genesis block)

5. Run the daemons of the respective nodes "multichaind -datadir=[data directory where you have created the node] [chain-name] -daemon"

6. For example, the commands would be of the form :

multichaind chaindemo -daemon
multichaind -datadir=C:\Users\NEHA\AppData\Roaming\MultiChain\chaindemoF1 -port=6751 -rpcport=6750 chaindemo -daemon
multichaind -datadir=C:\Users\NEHA\AppData\Roaming\MultiChain\chaindemoF2 -port=6753 -rpcport=6752 chaindemo -daemon
multichaind -datadir=C:\Users\NEHA\AppData\Roaming\MultiChain\chaindemoR1 -port=6755 -rpcport=6754 chaindemo -daemon
multichaind -datadir=C:\Users\NEHA\AppData\Roaming\MultiChain\chaindemoR2 -port=6757 -rpcport=6756 chaindemo -daemon

Grant necessary permissions.

7. In the project folder, do the following changes in config.txt file

default.name=Default                # name to display in the web interface
default.rpchost=127.0.0.1           # IP address of MultiChain node
default.rpcport=12345               # usually default-rpc-port from params.dat
default.rpcuser=multichainrpc       # username for RPC from multichain.conf
default.rpcpassword=mnBh8aHp4mun... # password for RPC from multichain.conf

Set the default.rpcuser and default.rpcpassword same as the username and password in multichain.conf which will be created in the %appdata% folder inside the multichain folder, under chain name.

For other nodes, refer the configuration from the config.txt in the folder.

8. After doing all these changes, run the daemon on all the nodes again.

9. Open the Xampp control panel and start the Apache Server. Run the login.html file as localhost:8080//login.html

(Note : You have to configure all the files in the folder according to the wallet addresses of your node)

