#!/bin/bash
API_URL="https://corpfile-app-production.up.railway.app/api_doc_upload"
API_KEY="corpfile-import-2026"
FILES_DIR="/Users/danieltang/Downloads/corpfile2/scraped-files"
TOTAL=0
OK=0
ERR=0

for company_dir in "$FILES_DIR"/*/; do
  company=$(basename "$company_dir")
  for file in "$company_dir"*; do
    [ -f "$file" ] || continue
    TOTAL=$((TOTAL + 1))
    filename=$(basename "$file")

    result=$(curl -s -X POST "$API_URL" \
      -H "x-api-key: $API_KEY" \
      -F "file=@$file" \
      -F "company=$company" \
      --max-time 120 2>/dev/null)

    if echo "$result" | grep -q '"ok":true'; then
      OK=$((OK + 1))
    else
      ERR=$((ERR + 1))
    fi

    if [ $((TOTAL % 100)) -eq 0 ]; then
      echo "[${TOTAL}] OK: ${OK}, Errors: ${ERR} — ${company}/${filename}"
    fi
  done
done

echo "Done! Total: ${TOTAL}, OK: ${OK}, Errors: ${ERR}"
