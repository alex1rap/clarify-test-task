ARG NODE_VERSION=21.6

FROM node:${NODE_VERSION}-alpine as build

WORKDIR /app

COPY frontend/package*.json ./
RUN npm install

COPY frontend .

RUN npm run build
