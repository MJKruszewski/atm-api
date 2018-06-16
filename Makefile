swagger_path = `pwd`/swagger.json
swagger_out = `pwd`/swagger-doc

generate-swagger: ; @docker run -v $(swagger_path):/home/swagger.json -v $(swagger_out):/home/docs swaggerapi/swagger-codegen-cli generate -l dynamic-html -i /home/swagger.json -o /home/docs
