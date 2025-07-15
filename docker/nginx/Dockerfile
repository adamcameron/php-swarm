FROM nginx:bookworm

WORKDIR /usr/share/nginx/

RUN echo "alias ll='ls -alF'" >> ~/.bashrc
RUN echo "alias cls='clear; printf \"\033[3J\"'" >> ~/.bashrc

COPY etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY etc/nginx/conf.d/ /etc/nginx/conf.d/

HEALTHCHECK \
    --start-period=30s \
    --interval=30s \
    --timeout=3s \
    --retries=3 \
    CMD curl -o /dev/null -s -w "%{http_code}\n" "http://host.docker.internal:8080/nginx-health.html" | grep "200" || exit 1

CMD ["nginx"]
EXPOSE 80
