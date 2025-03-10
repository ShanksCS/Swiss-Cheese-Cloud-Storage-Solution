FROM kalilinux/kali-rolling

# Install XFCE and VNC server
RUN apt update && apt install -y \
    xfce4 \
    xfce4-terminal \
    tightvncserver \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

# Set up VNC server
RUN mkdir -p ~/.vnc \
    && echo "scsspass" | vncpasswd -f > ~/.vnc/passwd \
    && chmod 600 ~/.vnc/passwd

# Expose VNC port
EXPOSE 5901

# Start VNC server
CMD ["vncserver", "-geometry", "1280x800", ":1"]
