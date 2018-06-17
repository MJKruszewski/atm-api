swagger_path = `pwd`/swagger.json
swagger_out = `pwd`/swagger-doc

generate-swagger: ; @docker run -v $(swagger_path):/home/swagger.json -v $(swagger_out):/home/docs swaggerapi/swagger-codegen-cli generate -l html2 -i /home/swagger.json -o /home/docs && docker rm `docker ps -aq -f ancestor=swaggerapi/swagger-codegen-cli -f status=exited`
