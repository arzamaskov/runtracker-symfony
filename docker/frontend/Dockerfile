FROM node:22-alpine AS builder

WORKDIR /app

# Copy package files
COPY frontend/package*.json ./

# Install dependencies
RUN npm install -g pnpm && pnpm install

# Copy source files
COPY frontend/ ./

# Build the application
RUN pnpm run build

# Production stage - serve with nginx
FROM nginx:alpine

# Copy built files
COPY --from=builder /app/build /usr/share/nginx/html

# The nginx configuration will be provided by docker-compose volume mount

EXPOSE 80
