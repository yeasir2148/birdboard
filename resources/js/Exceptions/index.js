class UnauthenticatedException extends Error {
   constructor(error) {
      super(error.message)
      this.name = 'Unauthenticated';
      this.statusCode = 401;
      this.message = error.message;
   }
}

export const RecordExistsEception = function(message) {
   this.name = 'Record Exists';
   this.message = message;
}

export { UnauthenticatedException } ;