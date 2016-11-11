Vagrant.configure(2) do |config|

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "ubuntu/xenial64"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8087" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 8087

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  #config.vm.network "private_network", ip: "192.168.33.10"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder "./src/", "/var/www/yii2template.lo.com/", id: "yii2template.lo.com", owner: "ubuntu", group: "ubuntu", mount_options: ["dmode=777,fmode=666"]

  # SHELL
  config.vm.provision "shell", path: "provision/provision.sh"
end
