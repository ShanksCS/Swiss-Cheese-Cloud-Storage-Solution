# Swiss Cheese Storage Solution (SCSS)

## Overview
The Swiss Cheese Storage Solution (SCSS) is a lightweight cybersecurity lab environment designed for hands-on training. It allows users to explore common attack techniques, such as SQL Injection, Directory Brute-Forcing, and Remote Code Execution, within a safe and isolated setup.

The project uses an Ubuntu host system inside Docker, running multiple virtual machines managed through Virtual Machine Manager (Virt-Manager). A deliberately vulnerable web application built with HTML, PHP, and SQL provides practical examples for learners to experiment with in a controlled environment.

## Project Structure
- **Ubuntu Host Machine**: Runs inside a Docker container.
- **Virtual Machines**:
  - **Ubuntu Server VM**: Hosts the vulnerable web application and SQL database.
  - **Kali Linux VM**: Used as the attacker machine for penetration testing activities.
- **Remote Access**: Provided through XRDP to allow desktop GUI access to the Ubuntu host.

## Key Features
- Lightweight and accessible on standard hardware.
- Pre-configured vulnerable web application.
- Common vulnerabilities:
  - SQL Injection
  - Directory Brute-Forcing
  - Remote Code Execution
- Isolated network setup to ensure safe and contained testing.

## Installation Instructions

[![Docker Pull](https://img.shields.io/badge/Docker-Pull-blue?logo=docker)](https://hub.docker.com/r/shanksc/scss-lab)

1. Install Docker Desktop from the official website:  
   [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)

2. Pull the SCSS project image from Docker Hub:
    ```bash
    docker pull shanksc/scss-lab
    ```

3. Start the SCSS container:
    ```bash
    docker run --name=scss-lab --privileged --tmpfs /run --tmpfs /run/lock \
    -v /dev/kvm:/dev/kvm -v /lib/modules:/lib/modules:ro \
    -p 3389:3389 shanksc/scss-lab:latest
    ```

4. Connect to the Ubuntu Host using an RDP client:
    - IP Address: (your machine’s IP address)
    - Port: 3389

5. Wait for the Kali Machine to load then begin testing vulnerabilities using the Kali Linux tools.

## Requirements
- Docker installed on the host machine
- 8 GB RAM minimum (16 GB recommended)
- CPU virtualization support (VT-x / AMD-V enabled in BIOS)

## Credits
Created by Charlie Shanks as part of a cybersecurity training project.

## Disclaimer
This environment is designed for educational use only. Always use ethical hacking practices and never attempt to exploit systems you do not own or have explicit permission to test.

---
