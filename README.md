## Finance API

### Database migrate and seeding
```
 php artisan migrate:fresh --seed
```

### Endpoints:
```
GET /api/employee/salary/{emplyee_id}
```
```
GET /api/company/expense?from={Y-m-d}&to={Y-m-d}

from & to - required params
```
```
GET /api/company/profit/income?from={Y-m-d}&to={Y-m-d}
GET /api/company/profit/profit?from={Y-m-d}&to={Y-m-d}

from & to - required params
```
