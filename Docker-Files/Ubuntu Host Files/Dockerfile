# Start with Ubuntu latest
FROM ubuntu:latest

# Install Lubuntu Desktop (LXQt)
RUN apt update && DEBIAN_FRONTEND=noninteractive apt install -y lubuntu-desktop

# Remove reboot required files to avoid issues
RUN rm -f /run/reboot-required*

# Create a user
RUN useradd -m host-SCSS -p $(openssl passwd -1 1234) && usermod -aG sudo host-SCSS

# Install XRDP for remote access
RUN apt install -y xrdp
RUN adduser xrdp ssl-cert

# Configure XRDP to use LXQt
RUN sed -i '3 a echo "\
export GNOME_SHELL_SESSION_MODE=Lubuntu\\n\
export XDG_SESSION_TYPE=x11\\n\
export XDG_CURRENT_DESKTOP=LXQt\\n\
export XDG_CONFIG_DIRS=/etc/xdg/xdg-Lubuntu:/etc/xdg\\n\
" > ~/.xsessionrc' /etc/xrdp/startwm.sh

# Install C++ compiler
RUN apt install -y g++

# Set working directory for the application
WORKDIR /app

# Create a custom start script to clean up old pid file and start XRDP service
COPY start-xrdp.sh /usr/local/bin/start-xrdp.sh

# Make sure the script is executable
RUN chmod +x /usr/local/bin/start-xrdp.sh

# Expose RDP port
EXPOSE 3389

# Start XRDP and then open a shell
CMD ["/usr/local/bin/start-xrdp.sh"]
