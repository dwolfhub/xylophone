
Vagrant.configure(2) do |config|

  config.vm.box = "charlesportwoodii/php7_xenial64"
  config.vm.box_version = ">= 1.2.1"

  config.vm.network "forwarded_port", guest: 80, host: 8081
  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.synced_folder ".", "/vagrant", type: "nfs"

  config.vm.provision "shell", privileged: false, inline: <<-SHELL
    echo "Updating apt-get..."
    sudo apt-get update

    echo "Choosing PHP version 7.1"
    sudo update-alternatives --set php /usr/bin/php7.1

    echo "Done. Re-configuring Nginx..."
    sudo cp /var/www/config/vagrant/nginx.config /etc/nginx/conf/conf.d/http.conf
    sudo service nginx restart

    echo "Done. Setting up MySQL..."
    mysql -u root -proot < /var/www/config/vagrant/setup-mysql-db.sql

    echo "Done. Creating config/_db.php file..."
    cp /var/www/config/vagrant/_db.php /var/www/config/_db.php

    echo "Done. Installing nvm and npm dependencies..."
    source /home/vagrant/.nvm/nvm.sh
    cd /var/www
    nvm install v6.9.1
    npm rebuild node-sass
    npm install
    npm run dist

    echo "Done. Migrating database..."
    /home/vagrant/.bin/composer install -on
    ./xylophone migrations:migrate

  SHELL
end
