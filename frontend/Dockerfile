FROM node:20-alpine

# تثبيت bash و curl
RUN apk add --no-cache bash curl

# إنشاء مجلد العمل
WORKDIR /app

# نسخ package.json و package-lock.json فقط
COPY app/package*.json ./

# تبديل الملكية قبل تثبيت npm
RUN chown -R node:node /app

# التحويل لـ node user
USER node

# تثبيت الحزم
RUN npm install

# نسخ باقي الملفات
COPY --chown=node:node app/ .

# expose port ديال Vite
EXPOSE 5173

# تشغيل المشروع
CMD ["npm", "run", "dev", "--", "--host"]