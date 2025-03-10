#!/bin/bash
# Remove the PID file if it exists to avoid the "already running" error
rm -f /var/run/xrdp/xrdp-sesman.pid

# Stop the xrdp service if it's already running (in case of stale sessions)
service xrdp stop

# Start the xrdp service
service xrdp start

# Keep the container running
bash