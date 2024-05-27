#!/usr/bin/env bash

ENUM_PATHS="resources/scripts/common/enums resources/scripts/customer/enums resources/scripts/staff/enums"

BUILD_OUTPUT=$(php artisan build:ts-enum)
if [ $? != 0 ]; then
    echo "Error encountered when regenerating TS enum files."
    echo "$BUILD_OUTPUT"
    exit 1
fi

GIT_OUTPUT=$(git status $ENUM_PATHS --porcelain)

if [ -n "$GIT_OUTPUT" ]; then
    if [ "$GITHUB_ACTIONS" == true ]; then
        echo "Git detected changes after regenerating enums. You can run \`php artisan build:ts-enum\` to regenerate locally."
    else
        echo "Git detected changes after regenerating enums. Please commit the regenerated files."
    fi

    while IFS= read -r line; do
        status="${line:0:3}"
        echo ""
        case "$status" in
          "A  " | "?? ")
            echo "Created file ${line:3}"
            ;;
          " M ")
            echo "Changes detected in ${line:3}"
            git --no-pager diff "${line:3}"
            ;;
          *)
            echo "Changes in ${line:3}"
            ;;
        esac
    done <<< "$GIT_OUTPUT"
    echo ""
    exit 1
fi
