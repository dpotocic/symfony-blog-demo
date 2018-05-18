Vagrant.configure("2") do |config|
  config.vm.box = "ehi/centos_7_3"
  config.vm.box_version = "1.2"
  config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.hostname = "symfony-blog-demo"
  config.vbguest.auto_update = false

  config.vm.provider :virtualbox do |vb|
    vb.name = config.vm.hostname
	vb.customize ["modifyvm", :id, "--cableconnected1", "on"]
	vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--usb", "off"]
    vb.customize ["modifyvm", :id, "--usbehci", "off"]
    vb.customize ["modifyvm", :id, "--audio", "none"]
	#vb.gui = true
	vb.memory = "2048"
    vb.cpus = "4"
  end
  
  config.ssh.username = "root"
  config.ssh.password = "password"
  config.ssh.insert_key = false
  config.ssh.guest_port = 2222
  config.ssh.forward_agent = true
  
  config.vm.boot_timeout = 600
  

  config.vm.define config.vm.hostname
  config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
  config.vm.network "forwarded_port", guest: 443, host: 443, host_ip: "127.0.0.1"
  config.vm.network "forwarded_port", guest: 22, host: 2222, host_ip: "127.0.0.1", id: 'ssh'
  config.vm.synced_folder ".", "/var/www/html/", :mount_options => ["dmode=777", "fmode=777"]
  
  # installs all the requirements
  config.vm.provision :shell, :path => "vagrant/yum-for-necessities.sh"
  
  # configure apache
  config.vm.provision "file", source: "./vagrant/configs/httpd.conf", destination: "/etc/httpd/conf/httpd.conf" # setting up /var/ww/html/api/web as document root
  config.vm.provision "file", source: "./vagrant/configs/timezone.ini", destination: "/etc/php.d/timezone.ini"
  config.vm.provision "file", source: "./vagrant/configs/php.ini", destination: "/etc/php.ini"

  config.vm.provision :shell, :inline => "apachectl restart", run: "always"
  config.vm.provision :shell, :inline => "php /var/www/html/bin/console assetic:dump", run: "always"

end
