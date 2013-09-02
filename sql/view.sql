SELECT 
  "Matches"."matchId", 
  "Matches"."matchDate", 
  "PlayerSetParticipation"."userId", 
  SUM("PlayerSetParticipation"."placing")
FROM 
  public."Matches", 
  public."Sets", 
  public."PlayerSetParticipation"
WHERE 
  "Sets"."matchId" = "Matches"."matchId" AND
  "PlayerSetParticipation"."setId" = "Sets"."setId" AND
  "Matches"."matchType"='1v1'
GROUP BY "Matches"."matchId","PlayerSetParticipation"."userId"; 
