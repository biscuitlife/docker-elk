# elk-intro
elk入门测试

1. 部署elk服务（基于docker）
2. 配置日志采集



ELK: https://github.com/deviantony/docker-elk
地址: http://localhost:5601
账户密码: elastic / changeme



docker-compose.yml


```Yaml
filebeat:
    image: docker.elastic.co/beats/filebeat:7.5.0
    volumes:
    - ./conf/filebeat.yml:/usr/share/filebeat/filebeat.yml
    - ./log:/log
```

filebeat.yml

```Yaml

filebeat.inputs:
- type: log
  paths:
  - /log/*.log

setup.template.name: "app"
setup.template.pattern: "app"
setup.ilm.enabled: false

output.elasticsearch:
  hosts: ["192.168.1.102:9200"]
#  index: "app"
  index: "app-%{[agent.version]}-%{+yyyy.MM.dd}"
#  template.name: "filebeat"
#  template.pattern: "*"
#  template.path: "filebeat.template.json"
  template.overwrite: true
  username: "elastic"
  password: "changeme"


```

